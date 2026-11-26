<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('tipe', [
                'mutasi',
                'perawatan',
                'kondisi',
                'peminjaman',
                'pengembalian',
                'hilang',
                'ditemukan',
                'penghapusan',
                'catatan',
            ]);
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['asset_id', 'tipe']);
            $table->index(['tipe', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_logs');
    }
};
