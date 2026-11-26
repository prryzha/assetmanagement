<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('jenis_perawatan', 150);
            $table->string('teknisi', 120)->nullable();
            $table->date('tanggal_jadwal');
            $table->date('tanggal_selesai')->nullable();
            $table->decimal('biaya', 15, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->text('catatan_selesai')->nullable();
            $table->enum('status', ['Dijadwalkan', 'Dikerjakan', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['asset_id', 'status']);
            $table->index(['status', 'tanggal_jadwal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
