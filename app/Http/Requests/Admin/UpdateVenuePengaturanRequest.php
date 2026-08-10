<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVenuePengaturanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_venue' => ['nullable', 'string', 'max:255'],
            'jenis_lapangan' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:500'],
            'fasilitas' => ['nullable', 'string', 'max:2000'],
            'link_maps' => ['nullable', 'string', 'max:2048'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
