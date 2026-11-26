<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_STAFF = 'staff';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_STAFF,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'foto_profil',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Mencegah sistem kehilangan seluruh akun Admin (karena Manajemen User,
     * Profil Instansi, dan Disposal Aset eksklusif untuk Admin).
     */
    public function isLastAdmin(): bool
    {
        return $this->isAdmin()
            && static::where('role', self::ROLE_ADMIN)->where('id', '!=', $this->id)->doesntExist();
    }

    /**
     * Aturan validasi username tunggal yang dipakai ulang oleh Profil & Manajemen User.
     *
     * @return array<int, mixed>
     */
    public static function usernameRules(?int $ignoreId = null): array
    {
        return [
            'nullable',
            'string',
            'lowercase',
            'min:3',
            'max:30',
            'regex:/^[a-z0-9_.]+$/',
            Rule::unique(self::class, 'username')->ignore($ignoreId),
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function returnedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'returned_by');
    }

    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class, 'created_by');
    }

    public function assetLogs(): HasMany
    {
        return $this->hasMany(AssetLog::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function disposedAssets(): HasMany
    {
        return $this->hasMany(Asset::class, 'disposed_by');
    }
}
