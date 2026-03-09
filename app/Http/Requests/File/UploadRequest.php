<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'files' => 'required|array',
            'files.*' => [
                'required',
                'file',
                File::types(['pdf', 'docx'])->max(10240),
            ],
        ];
    }
}
