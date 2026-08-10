<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('gedungs')->where('status', 'aktif')->update(['status' => 'tersedia']);
        DB::table('gedungs')->where('status', 'nonaktif')->update(['status' => 'habis']);

        if (! Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        DB::table('gedungs')->where('status', 'tersedia')->update(['status' => 'aktif']);
        DB::table('gedungs')->where('status', 'habis')->update(['status' => 'nonaktif']);
        DB::table('gedungs')->where('status', 'pending')->update(['status' => 'aktif']);
    }
};
