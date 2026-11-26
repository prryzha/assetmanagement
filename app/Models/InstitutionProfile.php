<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionProfile extends Model
{
    protected $fillable = [
        'logo',
        'nama_instansi',
        'nama_singkat',
        'alamat',
        'telepon',
        'email',
        'website',
        'deskripsi',
    ];

    /**
     * Data profil instansi bersifat tunggal (global untuk seluruh aplikasi).
     */
    public static function current(): self
    {
        return static::firstOrNew(['id' => 1]);
    }
}
