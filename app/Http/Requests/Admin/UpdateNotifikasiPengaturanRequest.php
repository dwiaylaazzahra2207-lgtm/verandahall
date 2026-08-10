<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotifikasiPengaturanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'notify_email_booking' => ['sometimes', 'boolean'],
            'notify_email_review' => ['sometimes', 'boolean'],
            'notify_email_payment' => ['sometimes', 'boolean'],
            'notify_browser' => ['sometimes', 'boolean'],
        ];
    }
}
