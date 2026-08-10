<?php

namespace Database\Seeders;

use App\Models\Gedung;
use Illuminate\Database\Seeder;

class GedungSeeder extends Seeder
{
    public function run(): void
    {
        $gedungs = [
            [
                'nama'      => 'Aula Serbaguna Utama',
                'kapasitas' => 500,
                'harga'     => 5000000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
            [
                'nama'      => 'Ballroom Grand Verandah',
                'kapasitas' => 300,
                'harga'     => 7500000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
            [
                'nama'      => 'Ruang Pertemuan Executive',
                'kapasitas' => 80,
                'harga'     => 1500000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
            [
                'nama'      => 'Convention Hall Premier',
                'kapasitas' => 800,
                'harga'     => 12000000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
            [
                'nama'      => 'Garden Venue Outdoor',
                'kapasitas' => 200,
                'harga'     => 3500000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
            [
                'nama'      => 'Ruang Seminar Mini',
                'kapasitas' => 50,
                'harga'     => 750000,
                'foto'      => null,
                'status'    => 'tersedia',
            ],
        ];

        foreach ($gedungs as $data) {
            // Hanya insert jika nama belum ada, agar tidak duplikat
            Gedung::firstOrCreate(
                ['nama' => $data['nama']],
                $data
            );
        }

        $this->command->info('✓ ' . count($gedungs) . ' gedung berhasil ditambahkan.');
    }
}
