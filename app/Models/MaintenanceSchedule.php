<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSchedule extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DIJADWALKAN = 'Dijadwalkan';
    public const STATUS_DIKERJAKAN = 'Dikerjakan';
    public const STATUS_SELESAI = 'Selesai';
    public const STATUS_DIBATALKAN = 'Dibatalkan';

    public const STATUSES = [
        self::STATUS_DIJADWALKAN,
        self::STATUS_DIKERJAKAN,
        self::STATUS_SELESAI,
        self::STATUS_DIBATALKAN,
    ];

    protected $fillable = [
        'asset_id',
        'created_by',
        'jenis_perawatan',
        'teknisi',
        'tanggal_jadwal',
        'tanggal_selesai',
        'biaya',
        'catatan',
        'catatan_selesai',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jadwal' => 'date',
            'tanggal_selesai' => 'date',
            'biaya' => 'decimal:2',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
