<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
     $id = $this->route('employee')?->id;

        return [
            'emp_id'   => ['required','string','max:191', Rule::unique('employees','emp_id')->ignore($id)],
            'prefix_id'   => ['required','string','max:50'],
            'first_name' => ['required','string','max:191'],
            'last_name'  => ['required','string','max:191'],
            'phone'    => ['nullable','string','max:50'],
            'image'    => ['nullable','image','max:2048'], // 2MB

            'fingerprint_registered' => ['required','boolean'],
            'status'                 => ['required','boolean'],

            'dpm_id' => ['nullable','exists:departments,id'],
            'brn_id' => ['nullable','exists:branches,id'],
            'org_id' => ['required','exists:organizations,id'],
        ];
    }
}
