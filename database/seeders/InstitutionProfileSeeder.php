<?php

namespace Database\Seeders;

use App\Models\InstitutionProfile;
use Illuminate\Database\Seeder;

class InstitutionProfileSeeder extends Seeder
{
    public function run(): void
    {
        InstitutionProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_instansi' => 'SMK Negeri 4 Bandung',
                'nama_singkat' => 'SMKN 4 Bandung',
                'alamat' => 'Jl. Kliningan No. 6, Turangga, Kec. Lengkong, Kota Bandung, Jawa Barat 40264',
                'telepon' => '(022) 7303736',
                'email' => 'info@smkn4bdg.sch.id',
                'website' => 'https://smkn4bdg.sch.id',
                'deskripsi' => 'Sistem Informasi Manajemen Aset & Sarana Prasarana SMK Negeri 4 Bandung.',
            ]
        );
    }
}
