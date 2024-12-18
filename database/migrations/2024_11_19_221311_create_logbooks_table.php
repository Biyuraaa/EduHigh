<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('super_vision_id')->constrained('super_visions')->onDelete('cascade'); // Hubungkan dengan pengajuan
            $table->text('notes')->nullable();
            $table->date('date')->nullable();
            $table->text('comments')->nullable(); // Komentar dosen
            $table->integer('percentage')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending'); // Status verifikasi
            $table->timestamp('verified_at')->nullable(); // Waktu verifikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
