<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'   => [
                'required',
                'string',
                'max:100',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'prefix_id'  => ['required', 'exists:prefixes,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'phone'      => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'username'   => 'ชื่อผู้ใช้',
            'prefix_id'  => 'คำนำหน้า',
            'first_name' => 'ชื่อจริง',
            'last_name'  => 'นามสกุล',
            'phone'      => 'เบอร์โทรศัพท์',
        ];
    }
}
