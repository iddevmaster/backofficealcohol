<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
          return true; // ชั่วคราวเพื่อให้ผ่านก่อน
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
               return [
            'dpm_id' => [
                'required','string','max:50',
                // Rule::unique('departments','dpm_id')->ignore($id),
            ],
            'name'   => ['required','string','max:255'],
            'brn_id' => ['required','string','max:50'],
        ];
    }

      public function attributes(): array
    {
        return [
            'dpm_id' => 'รหัสแผนก',
            'name'   => 'ชื่อแผนก',
            'brn_id' => 'รหัสสาขา',
        ];
    }
}
