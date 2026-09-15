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
     * Tampilkan semua notifikasi milik user yang sedang login.
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $user = Auth::user();
        $notifikasi = $user
            ? $user->notifikasi()->latest()->paginate(15)
            : collect();

        $unreadCount = $user
            ? $user->notifikasi()->where('is_read', false)->count()
            : 0;

        return view('user.notifikasi.index', compact('notifikasi', 'unreadCount'));
    }

    /**
     * Tandai sebuah notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, Notifikasi $notifikasi): JsonResponse|RedirectResponse
    {
        // Pastikan notifikasi milik pengguna yang sedang login atau pengguna adalah admin
        if ($notifikasi->user_id && $notifikasi->user_id !== Auth::id() && !Auth::user()?->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke notifikasi ini.');
        }

        if (!$notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        $user = Auth::user();
        $unreadCount = $user
            ? Notifikasi::query()
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                    if ($user->isAdmin()) {
                        $q->orWhereNull('user_id');
                    }
                })
                ->where('is_read', false)
                ->count()
            : 0;

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
            $user = Auth::user();
            if ($user->isAdmin()) {
                Notifikasi::query()
                    ->where(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->orWhereNull('user_id');
                    })
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            } else {
                $user->notifikasi()->where('is_read', false)->update(['is_read' => true]);
            }
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
        // Pastikan notifikasi milik pengguna yang sedang login atau pengguna adalah admin
        if ($notifikasi->user_id && $notifikasi->user_id !== Auth::id() && !Auth::user()?->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke notifikasi ini.');
        }

        $notifikasi->delete();

        $user = Auth::user();
        $unreadCount = $user
            ? Notifikasi::query()
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                    if ($user->isAdmin()) {
                        $q->orWhereNull('user_id');
                    }
                })
                ->where('is_read', false)
                ->count()
            : 0;

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
