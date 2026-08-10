<?php

namespace App\Http\Requests\Admin;

use App\Models\OperationalSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJadwalPengaturanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'jam_buka' => $this->input('jam_buka') ?: null,
            'jam_tutup' => $this->input('jam_tutup') ?: null,
            'slot_menit' => $this->filled('slot_menit') ? $this->input('slot_menit') : null,
        ]);
    }

    public function rules(): array
    {
        $hari = array_keys(OperationalSchedule::hariChoices());

        return [
            'hari' => ['required', Rule::in($hari)],
            'jam_buka' => ['nullable', 'date_format:H:i'],
            'jam_tutup' => ['nullable', 'date_format:H:i'],
            'slot_menit' => ['nullable', 'integer', 'min:5', 'max:720'],
        ];
    }
}
