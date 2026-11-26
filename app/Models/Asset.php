<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_TERSEDIA = 'Tersedia';
    public const STATUS_DIPINJAM = 'Dipinjam';
    public const STATUS_PERBAIKAN = 'Perbaikan';
    public const STATUS_HILANG = 'Hilang';
    public const STATUS_DISPOSED = 'Disposed';

    public const STATUSES = [
        self::STATUS_TERSEDIA,
        self::STATUS_DIPINJAM,
        self::STATUS_PERBAIKAN,
        self::STATUS_HILANG,
        self::STATUS_DISPOSED,
    ];

    public const KONDISI_BAIK = 'Baik';
    public const KONDISI_KURANG_BAIK = 'Kurang Baik';
    public const KONDISI_RUSAK_BERAT = 'Rusak Berat';

    public const KONDISIS = [
        self::KONDISI_BAIK,
        self::KONDISI_KURANG_BAIK,
        self::KONDISI_RUSAK_BERAT,
    ];

    protected $fillable = [
        'kode_barang',
        'qr_token',
        'nama_barang',
        'merk',
        'nomor_seri',
        'category_id',
        'location_id',
        'penanggung_jawab',
        'kondisi',
        'status',
        'tahun_perolehan',
        'nilai_perolehan',
        'catatan',
        'foto',
        'disposal_reason',
        'disposal_notes',
        'disposed_at',
        'disposed_by',
    ];

    protected function casts(): array
    {
        return [
            'tahun_perolehan' => 'integer',
            'nilai_perolehan' => 'decimal:2',
            'disposed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Asset $asset): void {
            if (empty($asset->qr_token)) {
                $asset->qr_token = self::generateQrToken();
            }
        });
    }

    public static function generateQrToken(int $length = 12): string
    {
        do {
            $token = Str::lower(Str::random($length));
        } while (self::withTrashed()->where('qr_token', $token)->exists());

        return $token;
    }

    public static function generateKodeBarang(Category $category): string
    {
        return self::generateBulkKodeBarang($category, 1)[0];
    }

    /**
     * Menghasilkan kode barang berurutan yang aman dari bentrok (termasuk dengan data soft-deleted).
     *
     * @return list<string>
     */
    public static function generateBulkKodeBarang(Category $category, int $count): array
    {
        $kodeKategori = strtoupper($category->kode ?: substr($category->nama, 0, 3));
        $tahun = now()->format('Y');
        $prefix = $kodeKategori . '-' . $tahun . '-';

        $last = self::withTrashed()
            ->where('kode_barang', 'like', $prefix . '%')
            ->orderByDesc('kode_barang')
            ->value('kode_barang');

        $nextSeq = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextSeq = ((int) end($parts)) + 1;
        }

        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = $prefix . str_pad((string) ($nextSeq + $i), 4, '0', STR_PAD_LEFT);
        }

        return $codes;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', self::STATUS_DISPOSED);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_TERSEDIA);
    }

    public function canBeBorrowed(): bool
    {
        return $this->status === self::STATUS_TERSEDIA
            && ! $this->maintenanceSchedules()
                ->where('status', MaintenanceSchedule::STATUS_DIKERJAKAN)
                ->exists();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }

    public function disposer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disposed_by');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)
            ->where('status_peminjaman', Transaction::STATUS_DIPINJAM)
            ->latestOfMany();
    }

    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }

    public function activeMaintenance(): HasOne
    {
        return $this->hasOne(MaintenanceSchedule::class)
            ->where('status', MaintenanceSchedule::STATUS_DIKERJAKAN)
            ->latestOfMany();
    }

    public function assetLogs(): HasMany
    {
        return $this->hasMany(AssetLog::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /**
     * Invalidate semua cache statistik/dropdown saat status atau data aset berubah.
     */
    public static function forgetStatusCaches(): void
    {
        Cache::forget('dashboard_data');
        Cache::forget('filter_categories');
        Cache::forget('filter_locations');
        Cache::forget('available_assets');
        Cache::forget('all_assets');
        Cache::forget('header_notifications');
    }
}
