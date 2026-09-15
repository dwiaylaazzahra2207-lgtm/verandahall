<?php

namespace Tests\Feature;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotifikasiTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_mark_notification_as_read(): void
    {
        $user = User::factory()->create();

        $notifikasi = Notifikasi::create([
            'user_id' => $user->id,
            'title' => 'Test Notif',
            'message' => 'Ini pesan test',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('notifikasi.mark-as-read', $notifikasi));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'unread_count' => 0,
            ]);

        $this->assertTrue($notifikasi->fresh()->is_read);
    }

    public function test_user_cannot_mark_other_users_notification_as_read(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $notifikasiB = Notifikasi::create([
            'user_id' => $userB->id,
            'title' => 'Notif User B',
            'message' => 'Pesan B',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($userA)
            ->postJson(route('notifikasi.mark-as-read', $notifikasiB));

        $response->assertForbidden();
        $this->assertFalse($notifikasiB->fresh()->is_read);
    }

    public function test_user_can_mark_all_notifications_as_read(): void
    {
        $user = User::factory()->create();

        Notifikasi::create([
            'user_id' => $user->id,
            'title' => 'Notif 1',
            'message' => 'Pesan 1',
            'type' => 'info',
            'is_read' => false,
        ]);

        Notifikasi::create([
            'user_id' => $user->id,
            'title' => 'Notif 2',
            'message' => 'Pesan 2',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('notifikasi.mark-all-read'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'unread_count' => 0,
            ]);

        $this->assertEquals(0, $user->notifikasi()->where('is_read', false)->count());
    }

    public function test_user_can_view_all_notifications_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        Notifikasi::create([
            'user_id' => $user->id,
            'title' => 'Judul Test Notifikasi',
            'message' => 'Pesan lengkap test notifikasi',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('user.notifikasi.index'));

        $response->assertOk()
            ->assertSee('Semua Notifikasi')
            ->assertSee('Kembali')
            ->assertSee('Judul Test Notifikasi')
            ->assertSee('Pesan lengkap test notifikasi');
    }

    public function test_admin_can_view_all_notifications_page_with_back_url(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $notif = Notifikasi::create([
            'user_id' => $admin->id,
            'title' => 'Laporan Siap Diunduh',
            'message' => 'Laporan pemesanan periode ini telah siap.',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.laporan.index'))
            ->get(route('admin.notifikasi.index'));

        $response->assertOk()
            ->assertSee('Semua Notifikasi')
            ->assertSee('Kembali')
            ->assertSee(route('admin.laporan.index'))
            ->assertSee('Laporan Siap Diunduh')
            ->assertSee('btn-trash-notif');
    }

    public function test_admin_can_delete_notification(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $notif = Notifikasi::create([
            'user_id' => $admin->id,
            'title' => 'Notif Hapus Admin',
            'message' => 'Pesan yang akan dihapus',
            'type' => 'info',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)
            ->deleteJson(route('notifikasi.destroy', $notif));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'unread_count' => 0,
            ]);

        $this->assertDatabaseMissing('notifikasi', ['id' => $notif->id]);
    }
}
