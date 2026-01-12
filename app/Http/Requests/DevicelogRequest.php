<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DevicelogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // $id = $this->route('deviceslog')?->id;

        // dd($id);

        return [

            'serial_num'       => ['required', 'string', 'max:191'],
            // ถ้าต้องการตรวจเจาะจงว่าเป็น IP จริง: ใช้ 'nullable','ip'
            'ip_address'       => ['nullable', 'string', 'max:191'],


            // รับค่าจาก <input type="datetime-local"> ได้
          
            'latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'        => ['nullable', 'numeric', 'between:-180,180'],
            'tested_count'     => ['required', 'integer', 'min:0'],

        ];
    }

    public function messages(): array
    {
        return [
            'ip_address.regex' => 'รูปแบบ MAC address ไม่ถูกต้อง (ตัวอย่าง: AA:BB:CC:DD:EE:FF)',
        ];
    }
}
