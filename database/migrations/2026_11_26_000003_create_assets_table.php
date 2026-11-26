<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('qr_token', 32)->unique();
            $table->string('nama_barang', 150);
            $table->string('merk', 100)->nullable();
            $table->string('nomor_seri', 100)->nullable();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->string('penanggung_jawab', 100)->nullable();
            $table->enum('kondisi', ['Baik', 'Kurang Baik', 'Rusak Berat'])->default('Baik');
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Perbaikan', 'Hilang', 'Disposed'])->default('Tersedia');
            $table->unsignedSmallInteger('tahun_perolehan')->nullable();
            $table->decimal('nilai_perolehan', 15, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->string('foto')->nullable();

            // Metadata penghapusan / disposal aset (hanya Admin)
            $table->string('disposal_reason', 150)->nullable();
            $table->text('disposal_notes')->nullable();
            $table->timestamp('disposed_at')->nullable();
            $table->foreignId('disposed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'deleted_at']);
            $table->index(['category_id', 'status']);
            $table->index(['location_id', 'status']);
            $table->index('kondisi');
            $table->index('nama_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
