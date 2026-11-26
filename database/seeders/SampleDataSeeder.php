<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\AssetLog;
use App\Models\Category;
use App\Models\Location;
use App\Models\MaintenanceSchedule;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $staff = User::where('username', 'staf.sarpras')->first() ?? User::where('role', User::ROLE_STAFF)->first();

        $catElk = Category::where('kode', 'ELK')->firstOrFail();
        $catFur = Category::where('kode', 'FUR')->firstOrFail();
        $catPrk = Category::where('kode', 'PRK')->firstOrFail();
        $catOlr = Category::where('kode', 'OLR')->firstOrFail();

        $locRpl = Location::where('nama', 'Lab RPL')->firstOrFail();
        $locMm = Location::where('nama', 'Lab Multimedia')->firstOrFail();
        $locGuru = Location::where('nama', 'Ruang Guru')->firstOrFail();
        $locAula = Location::where('nama', 'Aula')->firstOrFail();
        $locGudang = Location::where('nama', 'Gudang Sarpras')->firstOrFail();

        $assetsData = [
            [
                'kode_barang' => 'ELK-2026-0001',
                'qr_token' => 'demo01thinkp',
                'nama_barang' => 'Laptop ThinkPad E14',
                'merk' => 'Lenovo',
                'nomor_seri' => 'LNV-E14-2026001',
                'category_id' => $catElk->id,
                'location_id' => $locRpl->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_TERSEDIA,
                'tahun_perolehan' => 2025,
                'nilai_perolehan' => 12500000,
                'catatan' => 'Unit praktik pemrograman Lab RPL.',
            ],
            [
                'kode_barang' => 'ELK-2026-0002',
                'qr_token' => 'demo02epsonp',
                'nama_barang' => 'Proyektor Epson EB-X06',
                'merk' => 'Epson',
                'nomor_seri' => 'EPS-X06-8821',
                'category_id' => $catElk->id,
                'location_id' => $locGuru->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_DIPINJAM,
                'tahun_perolehan' => 2024,
                'nilai_perolehan' => 6800000,
            ],
            [
                'kode_barang' => 'PRK-2026-0001',
                'qr_token' => 'demo03canon2',
                'nama_barang' => 'Kamera Canon 200D',
                'merk' => 'Canon',
                'nomor_seri' => 'CN-200D-4412',
                'category_id' => $catPrk->id,
                'location_id' => $locMm->id,
                'penanggung_jawab' => 'Ketua Jurusan MM',
                'kondisi' => Asset::KONDISI_KURANG_BAIK,
                'status' => Asset::STATUS_DIPINJAM,
                'tahun_perolehan' => 2023,
                'nilai_perolehan' => 9200000,
            ],
            [
                'kode_barang' => 'ELK-2026-0003',
                'qr_token' => 'demo04speakr',
                'nama_barang' => 'Speaker Portable',
                'merk' => 'Baretone',
                'nomor_seri' => 'BRT-15M-109',
                'category_id' => $catElk->id,
                'location_id' => $locAula->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_RUSAK_BERAT,
                'status' => Asset::STATUS_PERBAIKAN,
                'tahun_perolehan' => 2022,
                'nilai_perolehan' => 3750000,
            ],
            [
                'kode_barang' => 'ELK-2026-0004',
                'qr_token' => 'demo05vivobk',
                'nama_barang' => 'Laptop Asus Vivobook',
                'merk' => 'Asus',
                'nomor_seri' => 'AS-VB14-9032',
                'category_id' => $catElk->id,
                'location_id' => $locGuru->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_HILANG,
                'tahun_perolehan' => 2024,
                'nilai_perolehan' => 8900000,
                'catatan' => 'Dilaporkan hilang setelah kegiatan rapat luar.',
            ],
            [
                'kode_barang' => 'ELK-2026-0005',
                'qr_token' => 'demo06aclabr',
                'nama_barang' => 'AC Split Lab RPL',
                'merk' => 'Daikin',
                'nomor_seri' => 'DKN-2PK-004',
                'category_id' => $catElk->id,
                'location_id' => $locRpl->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_TERSEDIA,
                'tahun_perolehan' => 2023,
                'nilai_perolehan' => 7400000,
            ],
            [
                'kode_barang' => 'ELK-2026-0006',
                'qr_token' => 'demo07printr',
                'nama_barang' => 'Printer Epson L3210',
                'merk' => 'Epson',
                'nomor_seri' => 'EPS-L3210-771',
                'category_id' => $catElk->id,
                'location_id' => $locGuru->id,
                'penanggung_jawab' => 'Staf TU',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_TERSEDIA,
                'tahun_perolehan' => 2024,
                'nilai_perolehan' => 2650000,
            ],
            [
                'kode_barang' => 'FUR-2026-0001',
                'qr_token' => 'demo08kursil',
                'nama_barang' => 'Kursi Lipat Chitose',
                'merk' => 'Chitose',
                'nomor_seri' => null,
                'category_id' => $catFur->id,
                'location_id' => $locMm->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_TERSEDIA,
                'tahun_perolehan' => 2023,
                'nilai_perolehan' => 480000,
            ],
            [
                'kode_barang' => 'OLR-2026-0001',
                'qr_token' => 'demo09bolabs',
                'nama_barang' => 'Bola Basket Molten GG7X',
                'merk' => 'Molten',
                'nomor_seri' => null,
                'category_id' => $catOlr->id,
                'location_id' => $locGudang->id,
                'penanggung_jawab' => 'Guru Olahraga',
                'kondisi' => Asset::KONDISI_BAIK,
                'status' => Asset::STATUS_DIPINJAM,
                'tahun_perolehan' => 2025,
                'nilai_perolehan' => 650000,
            ],
            [
                'kode_barang' => 'ELK-2026-0007',
                'qr_token' => 'demo10kipasa',
                'nama_barang' => 'Kipas Angin Standing',
                'merk' => 'Miyako',
                'nomor_seri' => 'MYK-1606-21',
                'category_id' => $catElk->id,
                'location_id' => $locGudang->id,
                'penanggung_jawab' => 'Staf Sarpras',
                'kondisi' => Asset::KONDISI_RUSAK_BERAT,
                'status' => Asset::STATUS_DISPOSED,
                'tahun_perolehan' => 2019,
                'nilai_perolehan' => 380000,
                'disposal_reason' => 'Usang',
                'disposal_notes' => 'Motor terbakar dan biaya servis melebihi nilai aset.',
                'disposed_at' => now()->subDays(12),
                'disposed_by' => $admin?->id,
            ],
        ];

        $assets = [];
        foreach ($assetsData as $item) {
            $assets[$item['kode_barang']] = Asset::updateOrCreate(
                ['kode_barang' => $item['kode_barang']],
                $item
            );
        }

        // Seed transaksi contoh hanya sekali agar idempoten saat db:seed ulang
        if (Transaction::count() === 0) {
            // 1. Peminjaman aktif via QR Guest
            $trxQrActive = Transaction::create([
                'asset_id' => $assets['ELK-2026-0002']->id,
                'created_by' => null,
                'sumber' => Transaction::SUMBER_QR_GUEST,
                'nama_peminjam' => 'Rina Maharani',
                'kontak_peminjam' => '0812-3456-7788 · XII RPL 1',
                'keperluan' => 'Praktik presentasi proyek akhir kelas',
                'tanggal_pinjam' => now()->subHours(2),
                'tanggal_jatuh_tempo' => now()->addHours(3),
                'status_peminjaman' => Transaction::STATUS_DIPINJAM,
            ]);

            // 2. Peminjaman aktif via Panel (mendekati jatuh tempo)
            Transaction::create([
                'asset_id' => $assets['PRK-2026-0001']->id,
                'created_by' => $staff?->id,
                'sumber' => Transaction::SUMBER_PANEL,
                'nama_peminjam' => 'Dedi Kurniawan',
                'kontak_peminjam' => 'Guru · Multimedia',
                'keperluan' => 'Dokumentasi kegiatan kunjungan industri',
                'tanggal_pinjam' => now()->subHours(5),
                'tanggal_jatuh_tempo' => now()->addMinutes(45),
                'status_peminjaman' => Transaction::STATUS_DIPINJAM,
            ]);

            // 3. Peminjaman terlambat (overdue) via QR Guest
            Transaction::create([
                'asset_id' => $assets['OLR-2026-0001']->id,
                'created_by' => null,
                'sumber' => Transaction::SUMBER_QR_GUEST,
                'nama_peminjam' => 'Sari Wulandari',
                'kontak_peminjam' => '0857-1100-2233 · XI TKJ 2',
                'keperluan' => 'Latihan ekstrakurikuler basket sore',
                'tanggal_pinjam' => now()->subDays(2),
                'tanggal_jatuh_tempo' => now()->subHours(18),
                'status_peminjaman' => Transaction::STATUS_DIPINJAM,
            ]);

            // 4. Peminjaman selesai dikembalikan via QR Guest
            $trxReturned = Transaction::create([
                'asset_id' => $assets['ELK-2026-0001']->id,
                'created_by' => null,
                'returned_by' => null,
                'sumber' => Transaction::SUMBER_QR_GUEST,
                'nama_peminjam' => 'Bima Prakoso',
                'kontak_peminjam' => 'XI TKJ 1',
                'keperluan' => 'Presentasi kelompok mata pelajaran PBO',
                'tanggal_pinjam' => now()->subDay()->setHour(9),
                'tanggal_jatuh_tempo' => now()->subDay()->setHour(15),
                'tanggal_kembali' => now()->subDay()->setHour(14),
                'status_peminjaman' => Transaction::STATUS_DIKEMBALIKAN,
                'kondisi_kembali' => Transaction::KONDISI_KEMBALI_BAIK,
                'catatan_pengembalian' => 'Barang dikembalikan lengkap bersama charger.',
            ]);

            ActivityLog::create([
                'user_id' => null,
                'actor_type' => ActivityLog::ACTOR_QR_GUEST,
                'event' => 'transaction.borrowed_qr',
                'subject_type' => Transaction::class,
                'subject_id' => $trxQrActive->id,
                'description' => 'Rina Maharani meminjam Proyektor Epson EB-X06 via Scan QR (0812-3456-7788)',
            ]);

            ActivityLog::create([
                'user_id' => null,
                'actor_type' => ActivityLog::ACTOR_QR_GUEST,
                'event' => 'transaction.returned_qr',
                'subject_type' => Transaction::class,
                'subject_id' => $trxReturned->id,
                'description' => 'Bima Prakoso mengembalikan Laptop ThinkPad E14 via Scan QR, kondisi Baik',
            ]);
        }

        if (MaintenanceSchedule::count() === 0) {
            MaintenanceSchedule::create([
                'asset_id' => $assets['ELK-2026-0003']->id,
                'created_by' => $staff?->id,
                'jenis_perawatan' => 'Perbaikan kabel dan amplifier',
                'teknisi' => 'Teknisi Audio Bandung',
                'tanggal_jadwal' => now()->toDateString(),
                'catatan' => 'Suara mendengung saat volume tinggi.',
                'status' => MaintenanceSchedule::STATUS_DIKERJAKAN,
            ]);

            MaintenanceSchedule::create([
                'asset_id' => $assets['PRK-2026-0001']->id,
                'created_by' => $staff?->id,
                'jenis_perawatan' => 'Pembersihan sensor dan lensa',
                'teknisi' => 'Service Center Canon',
                'tanggal_jadwal' => now()->addDays(4)->toDateString(),
                'catatan' => 'Jadwal pembersihan berkala semester ganjil.',
                'status' => MaintenanceSchedule::STATUS_DIJADWALKAN,
            ]);

            MaintenanceSchedule::create([
                'asset_id' => $assets['ELK-2026-0005']->id,
                'created_by' => $staff?->id,
                'jenis_perawatan' => 'Servis berkala & cuci AC',
                'teknisi' => 'CV Sejuk Mandiri',
                'tanggal_jadwal' => now()->subDays(14)->toDateString(),
                'tanggal_selesai' => now()->subDays(13)->toDateString(),
                'biaya' => 450000,
                'catatan_selesai' => 'Filter dibersihkan dan freon ditambah.',
                'status' => MaintenanceSchedule::STATUS_SELESAI,
            ]);

            MaintenanceSchedule::create([
                'asset_id' => $assets['ELK-2026-0006']->id,
                'created_by' => $staff?->id,
                'jenis_perawatan' => 'Ganti head printer',
                'teknisi' => 'Internal Sarpras',
                'tanggal_jadwal' => now()->subDays(20)->toDateString(),
                'catatan' => 'Dibatalkan setelah deep cleaning berhasil mengatasi nozzle mampet.',
                'status' => MaintenanceSchedule::STATUS_DIBATALKAN,
            ]);
        }

        if (AssetLog::count() === 0) {
            AssetLog::create([
                'asset_id' => $assets['ELK-2026-0004']->id,
                'user_id' => $staff?->id,
                'tipe' => AssetLog::TIPE_MUTASI,
                'judul' => 'Mutasi lokasi aset',
                'deskripsi' => 'Dipindahkan dari Lab RPL ke Ruang Guru.',
                'meta' => [
                    'from_location_id' => $locRpl->id,
                    'from_location_name' => $locRpl->nama,
                    'to_location_id' => $locGuru->id,
                    'to_location_name' => $locGuru->nama,
                ],
            ]);

            AssetLog::create([
                'asset_id' => $assets['ELK-2026-0002']->id,
                'user_id' => $staff?->id,
                'tipe' => AssetLog::TIPE_MUTASI,
                'judul' => 'Mutasi lokasi aset',
                'deskripsi' => 'Dipindahkan dari Gudang Sarpras ke Ruang Guru.',
                'meta' => [
                    'from_location_id' => $locGudang->id,
                    'from_location_name' => $locGudang->nama,
                    'to_location_id' => $locGuru->id,
                    'to_location_name' => $locGuru->nama,
                ],
            ]);

            AssetLog::create([
                'asset_id' => $assets['FUR-2026-0001']->id,
                'user_id' => $admin?->id,
                'tipe' => AssetLog::TIPE_MUTASI,
                'judul' => 'Mutasi lokasi aset',
                'deskripsi' => 'Dipindahkan dari Aula ke Lab Multimedia.',
                'meta' => [
                    'from_location_id' => $locAula->id,
                    'from_location_name' => $locAula->nama,
                    'to_location_id' => $locMm->id,
                    'to_location_name' => $locMm->nama,
                ],
            ]);

            AssetLog::create([
                'asset_id' => $assets['ELK-2026-0007']->id,
                'user_id' => $admin?->id,
                'tipe' => AssetLog::TIPE_PENGHAPUSAN,
                'judul' => 'Aset dihapuskan (Disposal)',
                'deskripsi' => 'Alasan: Usang. Motor terbakar dan biaya servis melebihi nilai aset.',
                'meta' => ['alasan' => 'Usang'],
            ]);

            ActivityLog::create([
                'user_id' => $staff?->id,
                'actor_type' => ActivityLog::ACTOR_STAFF,
                'event' => 'asset.mutated',
                'subject_type' => Asset::class,
                'subject_id' => $assets['ELK-2026-0004']->id,
                'description' => 'Staf Sarpras mengubah lokasi Laptop Asus Vivobook dari Lab RPL ke Ruang Guru',
            ]);

            ActivityLog::create([
                'user_id' => $admin?->id,
                'actor_type' => ActivityLog::ACTOR_ADMIN,
                'event' => 'asset.disposed',
                'subject_type' => Asset::class,
                'subject_id' => $assets['ELK-2026-0007']->id,
                'description' => 'Kepala Sekolah menghapuskan aset Kipas Angin Standing (Alasan: Usang)',
            ]);

            ActivityLog::create([
                'user_id' => null,
                'actor_type' => ActivityLog::ACTOR_SYSTEM,
                'event' => 'system.seeded',
                'subject_type' => null,
                'subject_id' => null,
                'description' => 'Inisialisasi data awal sistem Manajemen Aset SMKN 4 Bandung selesai',
            ]);
        }
    }
}
