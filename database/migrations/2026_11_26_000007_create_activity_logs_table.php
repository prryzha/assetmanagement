<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('actor_type', ['admin', 'staff', 'qr_guest', 'system'])->default('system');
            $table->string('event', 100);
            $table->nullableMorphs('subject');
            $table->text('description');
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index('actor_type');
            $table->index('event');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
