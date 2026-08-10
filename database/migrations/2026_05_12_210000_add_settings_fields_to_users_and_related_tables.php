<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('foto');
            }
            if (! Schema::hasColumn('users', 'profile_venue_name')) {
                $table->string('profile_venue_name')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'short_description')) {
                $table->text('short_description')->nullable()->after('profile_venue_name');
            }
            if (! Schema::hasColumn('users', 'social_contact')) {
                $table->string('social_contact')->nullable()->after('short_description');
            }
            if (! Schema::hasColumn('users', 'notify_email_booking')) {
                $table->boolean('notify_email_booking')->default(true)->after('social_contact');
            }
            if (! Schema::hasColumn('users', 'notify_email_review')) {
                $table->boolean('notify_email_review')->default(true)->after('notify_email_booking');
            }
            if (! Schema::hasColumn('users', 'notify_email_payment')) {
                $table->boolean('notify_email_payment')->default(true)->after('notify_email_review');
            }
            if (! Schema::hasColumn('users', 'notify_browser')) {
                $table->boolean('notify_browser')->default(true)->after('notify_email_payment');
            }
        });

        if (! Schema::hasTable('venue_settings')) {
            Schema::create('venue_settings', function (Blueprint $table) {
                $table->id();
                $table->string('nama_venue')->nullable();
                $table->string('jenis_lapangan')->nullable();
                $table->string('lokasi')->nullable();
                $table->text('fasilitas')->nullable();
                $table->string('link_maps')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('operational_schedules')) {
            Schema::create('operational_schedules', function (Blueprint $table) {
                $table->id();
                $table->string('hari', 16)->unique();
                $table->time('jam_buka')->nullable();
                $table->time('jam_tutup')->nullable();
                $table->unsignedSmallInteger('slot_menit')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_schedules');
        Schema::dropIfExists('venue_settings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'profile_venue_name',
                'short_description',
                'social_contact',
                'notify_email_booking',
                'notify_email_review',
                'notify_email_payment',
                'notify_browser',
            ]);
        });
    }
};
