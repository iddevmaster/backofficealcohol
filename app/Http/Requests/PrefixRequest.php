<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrefixRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('prefix')?->id;

        return [
            'name' => [
                'required','string','max:100',
                Rule::unique('prefixes','name')->ignore($id),
            ],
        ];
    }

    public function attributes(): array
    {
        return ['name' => 'คำนำหน้า'];
    }
}
