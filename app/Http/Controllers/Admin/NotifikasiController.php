<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::query()
            ->where(function ($q) use ($user) {
                if ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhereNull('user_id');
                }
            })
            ->latest()
            ->paginate(15);

        $unreadCount = Notifikasi::query()
            ->where(function ($q) use ($user) {
                if ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhereNull('user_id');
                }
            })
            ->where('is_read', false)
            ->count();

        return view('admin.notifikasi.index', compact('notifikasi', 'unreadCount'));
    }
}