<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateJadwalPengaturanRequest;
use App\Http\Requests\Admin\UpdateKeamananPengaturanRequest;
use App\Http\Requests\Admin\UpdateNotifikasiPengaturanRequest;
use App\Http\Requests\Admin\UpdateProfilPengaturanRequest;
use App\Http\Requests\Admin\UpdateVenuePengaturanRequest;
use App\Models\OperationalSchedule;
use App\Models\VenueSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    private const TABS = ['profil', 'venue', 'jadwal', 'notifikasi', 'keamanan', 'bantuan'];

    public function index(Request $request, string $tab = 'profil'): View
    {
        if (! in_array($tab, self::TABS, true)) {
            abort(404);
        }

        $this->ensureSchedulesExist();

        $venue = VenueSetting::singleton();

        $hariChoices = OperationalSchedule::hariChoices();
        $selectedHari = $request->query('hari', 'senin');
        if (! array_key_exists($selectedHari, $hariChoices)) {
            $selectedHari = 'senin';
        }

        $schedule = OperationalSchedule::query()->firstOrCreate(['hari' => $selectedHari]);

        return view('admin.pengaturan.index', compact('tab', 'venue', 'hariChoices', 'selectedHari', 'schedule'));
    }

    public function updateProfil(UpdateProfilPengaturanRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->except(['password', 'foto'])->toArray();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profiles', 'public');
        }

        $user->fill($data);
        $user->save();

        return redirect()->route('admin.pengaturan.index', ['tab' => 'profil'])
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateVenue(UpdateVenuePengaturanRequest $request): RedirectResponse
    {
        $venue = VenueSetting::singleton();
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($venue->foto) {
                Storage::disk('public')->delete($venue->foto);
            }
            $data['foto'] = $request->file('foto')->store('venues', 'public');
        } else {
            unset($data['foto']);
        }

        $venue->update($data);

        return redirect()->route('admin.pengaturan.index', ['tab' => 'venue'])
            ->with('success', 'Data venue berhasil disimpan.');
    }

    public function updateJadwal(UpdateJadwalPengaturanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        OperationalSchedule::query()->updateOrCreate(
            ['hari' => $validated['hari']],
            [
                'jam_buka'   => $validated['jam_buka'] ?: null,
                'jam_tutup'  => $validated['jam_tutup'] ?: null,
                'slot_menit' => $validated['slot_menit'] ?? null,
            ]
        );

        return redirect()->route('admin.pengaturan.index', ['tab' => 'jadwal', 'hari' => $validated['hari']])
            ->with('success', 'Jadwal berhasil disimpan.');
    }

    public function updateNotifikasi(UpdateNotifikasiPengaturanRequest $request): RedirectResponse
    {
        $request->user()->update([
            'notify_email_booking' => $request->boolean('notify_email_booking'),
            'notify_email_review'  => $request->boolean('notify_email_review'),
            'notify_email_payment' => $request->boolean('notify_email_payment'),
            'notify_browser'       => $request->boolean('notify_browser'),
        ]);

        return redirect()->route('admin.pengaturan.index', ['tab' => 'notifikasi'])
            ->with('success', 'Pengaturan notifikasi disimpan.');
    }

    public function updateKeamanan(UpdateKeamananPengaturanRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return redirect()->route('admin.pengaturan.index', ['tab' => 'keamanan'])
            ->with('success', 'Password berhasil diubah.');
    }

    private function ensureSchedulesExist(): void
    {
        foreach (array_keys(OperationalSchedule::hariChoices()) as $hari) {
            OperationalSchedule::query()->firstOrCreate(
                ['hari' => $hari],
                []
            );
        }

        VenueSetting::singleton();
    }
}
