<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Gedung;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@verandahall.com'],
            [
                'name' => 'Admin VerandaHall',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $pelanggan = User::query()->updateOrCreate(
            ['email' => 'user@verandahall.com'],
            [
                'name' => 'Pengguna Demo',
                'password' => Hash::make('user1234'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $gedung = Gedung::query()->firstOrCreate(
            ['nama' => 'Gedung Serbaguna Sentosa'],
            [
                'kapasitas' => 500,
                'harga' => 5_000_000,
                'status' => 'tersedia',
            ]
        );

        Gedung::query()->firstOrCreate(
            ['nama' => 'Gedung Serbaguna Sidoarjo'],
            [
                'kapasitas' => 300,
                'harga' => 3_500_000,
                'status' => 'pending',
            ]
        );

        Booking::query()->firstOrCreate(
            [
                'user_id' => $pelanggan->id,
                'gedung_id' => $gedung->id,
                'tanggal_booking' => now()->addDays(5)->toDateString(),
                'jam_mulai' => '09:00:00',
            ],
            [
                'jam_selesai' => '12:00:00',
                'status' => Booking::STATUS_MENUNGGU,
            ]
        );

        Booking::query()->firstOrCreate(
            [
                'user_id' => $pelanggan->id,
                'gedung_id' => $gedung->id,
                'tanggal_booking' => now()->addDays(12)->toDateString(),
                'jam_mulai' => '14:00:00',
            ],
            [
                'jam_selesai' => '17:00:00',
                'status' => Booking::STATUS_DISETUJUI,
            ]
        );

        Booking::query()->firstOrCreate(
            [
                'user_id' => $pelanggan->id,
                'gedung_id' => $gedung->id,
                'tanggal_booking' => now()->subDays(2)->toDateString(),
                'jam_mulai' => '08:00:00',
            ],
            [
                'jam_selesai' => '09:00:00',
                'status' => Booking::STATUS_SELESAI,
            ]
        );

        Booking::query()->firstOrCreate(
            [
                'user_id' => $pelanggan->id,
                'gedung_id' => $gedung->id,
                'tanggal_booking' => now()->subDays(10)->toDateString(),
                'jam_mulai' => '10:00:00',
            ],
            [
                'jam_selesai' => '11:00:00',
                'status' => Booking::STATUS_DIBATALKAN,
            ]
        );

        // Bersihkan akun seed lama agar tidak membingungkan saat login
        User::query()->where('email', 'admin@verandahall.test')->delete();
        User::query()->where('email', 'user@verandahall.test')->delete();
        User::query()->where('email', 'test@example.com')->delete();
    }
}
