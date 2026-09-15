<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserPengaturanController extends Controller
{
    private const TABS = ['profil', 'keamanan', 'notifikasi', 'bantuan'];

    public function index(Request $request, string $tab = 'profil'): View
    {
        if (! in_array($tab, self::TABS, true)) {
            abort(404);
        }

        return view('user.pengaturan.index', compact('tab'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'foto'  => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('profiles', 'public');
        } else {
            unset($validated['foto']);
        }

        $user->update($validated);

        return redirect()->route('user.pengaturan.index', ['tab' => 'profil'])
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateKeamanan(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'  => ['required', 'current_password'],
            'password'          => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('user.pengaturan.index', ['tab' => 'keamanan'])
            ->with('success', 'Password berhasil diubah.');
    }

    public function updateNotifikasi(Request $request): RedirectResponse
    {
        $request->user()->update([
            'notify_email_booking' => $request->boolean('notify_email_booking'),
            'notify_email_review'  => $request->boolean('notify_email_review'),
            'notify_email_payment' => $request->boolean('notify_email_payment'),
            'notify_browser'       => $request->boolean('notify_browser'),
        ]);

        return redirect()->route('user.pengaturan.index', ['tab' => 'notifikasi'])
            ->with('success', 'Pengaturan notifikasi disimpan.');
    }
}
