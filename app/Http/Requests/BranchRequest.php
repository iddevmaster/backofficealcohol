<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
         return [
            'brn_id'      => ['required','string','max:50'/*, Rule::unique('branches','brn_id')->ignore($id)*/],
            'name'        => ['required','string','max:255'],
            'address'     => ['required','string','max:500'],
            'tambon_id'   => ['required','integer'],
            'amphur_id'   => ['required','integer'],
            'province_id' => ['required','integer'],
            'org_id'      => ['required','string','max:50'],
        ];
    }

        public function attributes(): array
    {
        return [
            'brn_id'      => 'รหัสสาขา',
            'name'        => 'ชื่อสาขา',
            'address'     => 'ที่อยู่',
            'tambon_id'   => 'ตำบล',
            'amphur_id'   => 'อำเภอ',
            'province_id' => 'จังหวัด',
            'org_id'      => 'รหัสองค์กร',
        ];
    }
}
