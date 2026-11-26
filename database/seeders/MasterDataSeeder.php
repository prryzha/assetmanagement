<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama' => 'Elektronik', 'kode' => 'ELK'],
            ['nama' => 'Furnitur', 'kode' => 'FUR'],
            ['nama' => 'Alat Praktik', 'kode' => 'PRK'],
            ['nama' => 'Olahraga', 'kode' => 'OLR'],
            ['nama' => 'Lainnya', 'kode' => 'LNY'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['kode' => $category['kode']], $category);
        }

        $locations = [
            ['nama' => 'Lab RPL', 'kode' => 'L-RPL', 'gedung' => 'Gedung A'],
            ['nama' => 'Lab TKJ', 'kode' => 'L-TKJ', 'gedung' => 'Gedung A'],
            ['nama' => 'Lab Multimedia', 'kode' => 'L-MM', 'gedung' => 'Gedung B'],
            ['nama' => 'Ruang Guru', 'kode' => 'R-GRU', 'gedung' => 'Gedung Utama'],
            ['nama' => 'Aula', 'kode' => 'AULA', 'gedung' => 'Gedung Utama'],
            ['nama' => 'Gudang Sarpras', 'kode' => 'GDG', 'gedung' => 'Gedung C'],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(['nama' => $location['nama']], $location);
        }
    }
}
