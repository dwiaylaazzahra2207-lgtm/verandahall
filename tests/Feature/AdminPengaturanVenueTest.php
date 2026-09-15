<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VenueSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPengaturanVenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_venue_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->image('venue.jpg');
        $path = $file->store('venues', 'public');

        $venue = VenueSetting::singleton();
        $venue->update(['foto' => $path]);

        $this->assertTrue(Storage::disk('public')->exists($path));

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.pengaturan.delete-venue-foto'));

        $response
            ->assertRedirect(route('admin.pengaturan.index', ['tab' => 'venue']))
            ->assertSessionHas('success');

        $this->assertFalse(Storage::disk('public')->exists($path));
        $this->assertNull($venue->fresh()->foto);
    }

    public function test_admin_can_delete_venue_data(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->image('venue.jpg');
        $path = $file->store('venues', 'public');

        $venue = VenueSetting::singleton();
        $venue->update([
            'nama_venue' => 'Veranda Hall',
            'jenis_lapangan' => 'Gedung Serbaguna',
            'lokasi' => 'Sidoarjo',
            'fasilitas' => 'AC, Sound System',
            'link_maps' => 'https://maps.google.com',
            'foto' => $path,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.pengaturan.delete-venue'));

        $response
            ->assertRedirect(route('admin.pengaturan.index', ['tab' => 'venue']))
            ->assertSessionHas('success');

        $this->assertFalse(Storage::disk('public')->exists($path));

        $fresh = $venue->fresh();
        $this->assertNull($fresh->nama_venue);
        $this->assertNull($fresh->jenis_lapangan);
        $this->assertNull($fresh->lokasi);
        $this->assertNull($fresh->fasilitas);
        $this->assertNull($fresh->link_maps);
        $this->assertNull($fresh->foto);
    }
}
