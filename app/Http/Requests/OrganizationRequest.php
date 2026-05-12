<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
 public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'org_id'   => ['nullable','uuid'],  // ถ้าไม่ส่งมา จะ gen อัตโนมัติใน Controller
            'org_code' => ['required','string','max:50'],
            'name'     => ['required','string','max:255'],
            'logo'     => ['nullable','string','max:255'], // เก็บ path/URL เป็น string
            'status'   => ['required','boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'org_id'   => 'รหัสองค์กร (UUID)',
            'org_code' => 'ตัวย่อองค์กร',
            'name'     => 'ชื่อองค์กร',
            'logo'     => 'โลโก้',
            'status'   => 'สถานะ',
        ];
    }
}
