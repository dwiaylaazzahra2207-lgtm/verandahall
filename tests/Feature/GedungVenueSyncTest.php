<?php

namespace Tests\Feature;

use App\Models\Gedung;
use App\Models\User;
use App\Models\VenueSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GedungVenueSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_gedung_syncs_photo_and_name_to_venue_settings(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->image('gedung_baru.jpg');

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.gedung.store'), [
                'nama' => 'Gedung Utama Veranda',
                'kapasitas' => 500,
                'harga' => 1500000,
                'status' => 'tersedia',
                'foto' => $file,
                'sync_venue' => 1,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.gedung.index'));

        $this->assertDatabaseHas('gedungs', [
            'nama' => 'Gedung Utama Veranda',
        ]);

        $venue = VenueSetting::singleton();
        $this->assertSame('Gedung Utama Veranda', $venue->nama_venue);
        $this->assertNotNull($venue->foto);
        $this->assertTrue(Storage::disk('public')->exists($venue->foto));
    }

    public function test_pengaturan_index_autopopulates_from_latest_gedung_if_venue_setting_is_empty(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->image('gedung_lama.jpg');
        $path = $file->store('gedungs', 'public');

        Gedung::query()->create([
            'nama' => 'Gedung Serbaguna A',
            'kapasitas' => 200,
            'harga' => 500000,
            'status' => 'tersedia',
            'foto' => $path,
        ]);

        // Ensure venue setting has empty fields initially
        $venue = VenueSetting::singleton();
        $venue->update(['nama_venue' => null, 'foto' => null]);

        $response = $this
            ->actingAs($admin)
            ->get(route('admin.pengaturan.index', ['tab' => 'venue']));

        $response->assertOk();

        $venue->refresh();
        $this->assertSame('Gedung Serbaguna A', $venue->nama_venue);
        $this->assertSame($path, $venue->foto);
    }
}
