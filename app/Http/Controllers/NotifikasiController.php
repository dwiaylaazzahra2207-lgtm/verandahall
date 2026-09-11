<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tandai sebuah notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, Notifikasi $notifikasi): JsonResponse|RedirectResponse
    {
        // Pastikan notifikasi milik pengguna yang sedang login
        if ($notifikasi->user_id && $notifikasi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke notifikasi ini.');
        }

        if (!$notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        $unreadCount = Auth::user() ? Auth::user()->notifikasi()->where('is_read', false)->count() : 0;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai sudah dibaca.',
                'unread_count' => $unreadCount,
            ]);
        }

        return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi milik user aktif sebagai sudah dibaca.
     */
    public function markAllAsRead(Request $request): JsonResponse|RedirectResponse
    {
        if (Auth::check()) {
            Auth::user()->notifikasi()->where('is_read', false)->update(['is_read' => true]);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai sudah dibaca.',
                'unread_count' => 0,
            ]);
        }

        return back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Hapus sebuah notifikasi.
     */
    public function destroy(Request $request, Notifikasi $notifikasi): JsonResponse|RedirectResponse
    {
        // Pastikan notifikasi milik pengguna yang sedang login
        if ($notifikasi->user_id && $notifikasi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke notifikasi ini.');
        }

        $notifikasi->delete();

        $unreadCount = Auth::user() ? Auth::user()->notifikasi()->where('is_read', false)->count() : 0;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus.',
                'unread_count' => $unreadCount,
            ]);
        }

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
