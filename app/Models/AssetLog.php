<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetLog extends Model
{
    use HasFactory;

    public const TIPE_MUTASI = 'mutasi';
    public const TIPE_PERAWATAN = 'perawatan';
    public const TIPE_KONDISI = 'kondisi';
    public const TIPE_PEMINJAMAN = 'peminjaman';
    public const TIPE_PENGEMBALIAN = 'pengembalian';
    public const TIPE_HILANG = 'hilang';
    public const TIPE_DITEMUKAN = 'ditemukan';
    public const TIPE_PENGHAPUSAN = 'penghapusan';
    public const TIPE_CATATAN = 'catatan';

    public const TIPES = [
        self::TIPE_MUTASI,
        self::TIPE_PERAWATAN,
        self::TIPE_KONDISI,
        self::TIPE_PEMINJAMAN,
        self::TIPE_PENGEMBALIAN,
        self::TIPE_HILANG,
        self::TIPE_DITEMUKAN,
        self::TIPE_PENGHAPUSAN,
        self::TIPE_CATATAN,
    ];

    protected $fillable = [
        'asset_id',
        'user_id',
        'tipe',
        'judul',
        'deskripsi',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public static function record(
        Asset $asset,
        string $tipe,
        string $judul,
        ?string $deskripsi = null,
        array $meta = [],
        ?int $userId = null,
    ): self {
        return self::create([
            'asset_id' => $asset->id,
            'user_id' => $userId ?? auth()->id(),
            'tipe' => $tipe,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'meta' => empty($meta) ? null : $meta,
        ]);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
