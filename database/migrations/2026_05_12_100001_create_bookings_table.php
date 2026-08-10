<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('gedung_id')->constrained('gedungs')->cascadeOnDelete();
            $table->date('tanggal_booking');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->string('status')->default('menunggu'); // menunggu | disetujui | ditolak | selesai | dibatalkan
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->index(['gedung_id', 'tanggal_booking', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
