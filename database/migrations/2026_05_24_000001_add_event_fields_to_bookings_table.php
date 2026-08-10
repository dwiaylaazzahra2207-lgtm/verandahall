<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('nama_acara')->nullable()->after('jam_selesai');
            $table->unsignedInteger('jumlah_orang')->nullable()->after('nama_acara');
            $table->text('catatan')->nullable()->after('jumlah_orang');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['nama_acara', 'jumlah_orang', 'catatan']);
        });
    }
};
