<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GedungStoreRequest;
use App\Http\Requests\Admin\GedungUpdateRequest;
use App\Models\Gedung;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GedungController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gedung::query()->latest();

        if ($request->filled('q')) {
            $term = $request->input('q');
            $query->where('nama', 'like', '%'.$term.'%');
        }

        $status = $request->input('status');
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        $gedungs = $query->paginate(12)->withQueryString();

        return view('admin.gedung.index', compact('gedungs'));
    }

    public function create(): View
    {
        return view('admin.gedung.create');
    }

    public function store(GedungStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('gedungs', 'public');
        } else {
            unset($data['foto']);
        }

        Gedung::query()->create($data);

        return redirect()->route('admin.gedung.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function show(Gedung $gedung): View
    {
        return view('admin.gedung.show', compact('gedung'));
    }

    public function edit(Gedung $gedung): View
    {
        return view('admin.gedung.edit', compact('gedung'));
    }

    public function update(GedungUpdateRequest $request, Gedung $gedung): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($gedung->foto) {
                Storage::disk('public')->delete($gedung->foto);
            }
            $data['foto'] = $request->file('foto')->store('gedungs', 'public');
        } else {
            unset($data['foto']);
        }

        $gedung->update($data);

        return redirect()->route('admin.gedung.index')
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung): RedirectResponse
    {
        if ($gedung->foto) {
            Storage::disk('public')->delete($gedung->foto);
        }

        $gedung->delete();

        return redirect()->route('admin.gedung.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }
}
