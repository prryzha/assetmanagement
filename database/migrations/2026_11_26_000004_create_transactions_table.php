<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('returned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('sumber', ['panel', 'qr_guest'])->default('panel');
            $table->string('nama_peminjam', 120);
            $table->string('kontak_peminjam', 120)->nullable();
            $table->text('keperluan');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_jatuh_tempo')->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->enum('status_peminjaman', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->enum('kondisi_kembali', ['Baik', 'Ada Kerusakan'])->nullable();
            $table->string('foto_pengembalian')->nullable();
            $table->text('catatan_pengembalian')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['asset_id', 'status_peminjaman']);
            $table->index(['status_peminjaman', 'tanggal_jatuh_tempo']);
            $table->index('sumber');
            $table->index('tanggal_pinjam');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
