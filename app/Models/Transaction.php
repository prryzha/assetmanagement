<?php

namespace App\Models;

use DateInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DIPINJAM = 'Dipinjam';
    public const STATUS_DIKEMBALIKAN = 'Dikembalikan';

    public const STATUSES = [
        self::STATUS_DIPINJAM,
        self::STATUS_DIKEMBALIKAN,
    ];

    public const SUMBER_PANEL = 'panel';
    public const SUMBER_QR_GUEST = 'qr_guest';

    public const SUMBERS = [
        self::SUMBER_PANEL,
        self::SUMBER_QR_GUEST,
    ];

    public const KONDISI_KEMBALI_BAIK = 'Baik';
    public const KONDISI_KEMBALI_RUSAK = 'Ada Kerusakan';

    public const KONDISI_KEMBALIS = [
        self::KONDISI_KEMBALI_BAIK,
        self::KONDISI_KEMBALI_RUSAK,
    ];

    protected $fillable = [
        'asset_id',
        'created_by',
        'returned_by',
        'sumber',
        'nama_peminjam',
        'kontak_peminjam',
        'keperluan',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status_peminjaman',
        'kondisi_kembali',
        'foto_pengembalian',
        'catatan_pengembalian',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'datetime',
            'tanggal_jatuh_tempo' => 'datetime',
            'tanggal_kembali' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status_peminjaman', self::STATUS_DIPINJAM)
            ->whereNull('tanggal_kembali');
    }

    /**
     * Peminjaman aktif yang melewati batas pengembalian.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->active()
            ->whereNotNull('tanggal_jatuh_tempo')
            ->where('tanggal_jatuh_tempo', '<', now());
    }

    public function scopeDueWithinHours(Builder $query, int $hours): Builder
    {
        return $query->active()
            ->whereNotNull('tanggal_jatuh_tempo')
            ->whereBetween('tanggal_jatuh_tempo', [now(), now()->addHours($hours)]);
    }

    public function isFromQrGuest(): bool
    {
        return $this->sumber === self::SUMBER_QR_GUEST;
    }

    public function isOverdue(): bool
    {
        return $this->status_peminjaman === self::STATUS_DIPINJAM
            && $this->tanggal_kembali === null
            && $this->tanggal_jatuh_tempo !== null
            && $this->tanggal_jatuh_tempo->isPast();
    }

    public function isDueWithinHours(int $hours): bool
    {
        return $this->status_peminjaman === self::STATUS_DIPINJAM
            && $this->tanggal_kembali === null
            && $this->tanggal_jatuh_tempo !== null
            && $this->tanggal_jatuh_tempo->isFuture()
            && now()->diffInMinutes($this->tanggal_jatuh_tempo, false) <= $hours * 60;
    }

    public function overdueDuration(): ?string
    {
        if (! $this->isOverdue()) {
            return null;
        }

        return self::formatDuration($this->tanggal_jatuh_tempo->diff(now()));
    }

    public function dueSoonDuration(): ?string
    {
        if (
            $this->status_peminjaman !== self::STATUS_DIPINJAM
            || $this->tanggal_kembali !== null
            || $this->tanggal_jatuh_tempo === null
            || $this->tanggal_jatuh_tempo->isPast()
        ) {
            return null;
        }

        return self::formatDuration(now()->diff($this->tanggal_jatuh_tempo));
    }

    private static function formatDuration(DateInterval $diff): string
    {
        if ($diff->days >= 1) {
            return $diff->days . ' hari';
        }

        if ($diff->h >= 1) {
            return $diff->h . ' jam';
        }

        return max(1, $diff->i) . ' menit';
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function returner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
