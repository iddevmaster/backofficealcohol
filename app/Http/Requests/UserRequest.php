<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
 public function authorize(): bool { return true; }

    public function rules(): array
    {
        $user = $this->route('user'); // Model binding: {user}
        $userId = $user?->id;

        return [
            'username'   => [
                'required','string','max:100',
                Rule::unique('users','username')->ignore($userId),
            ],
            'password'   => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'string','min:6','confirmed' // ต้องมี password_confirmation
            ],
            'prefix_id'     => ['required','string','max:50'],
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'role_id'    => ['required','string','max:100'],
            'dpm_id'     => ['nullable','string','max:100'],
            'brn_id'     => ['nullable','string','max:100'],
            'org_id'     => ['nullable','string','max:100'],
            'phone'      => ['nullable','string','max:30'],
            'status'     => ['nullable'], // จะ map เป็น boolean ใน controller
        ];
    }

    public function attributes(): array
    {
        return [
            'username'   => 'ชื่อผู้ใช้',
            'password'   => 'รหัสผ่าน',
            'password_confirmation' => 'ยืนยันรหัสผ่าน',
            'prefix_id'     => 'คำนำหน้า',
            'first_name' => 'ชื่อ',
            'last_name'  => 'นามสกุล',
            'role_id'    => 'บทบาท',
            'dpm_id'     => 'รหัสแผนก',
            'brn_id'     => 'รหัสสาขา',
            'org_id'     => 'รหัสองค์กร',
            'phone'      => 'โทรศัพท์',
            'status'     => 'สถานะ',
        ];
    }
}
