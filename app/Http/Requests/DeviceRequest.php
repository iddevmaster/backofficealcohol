<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
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
        $id = $this->route('device')?->id;

        return [
            'model'            => ['required','string','max:191'],
            'serial_num'       => ['required','string','max:191', Rule::unique('devices','serial_num')->ignore($id)],
            // ถ้าต้องการตรวจเจาะจงว่าเป็น IP จริง: ใช้ 'nullable','ip'
            'ip_address'       => ['nullable','string','max:191'],
            'sensor_sn'        => ['nullable','string','max:191'],
            'sensor_body_sn'   => ['nullable','string','max:191'],
            // ตรวจรูปแบบ MAC address มาตรฐาน
            'pi_mac_address'   => ['nullable','regex:/^([0-9A-Fa-f]{2}[:\-]){5}([0-9A-Fa-f]{2})$/'],
            // รับค่าจาก <input type="datetime-local"> ได้
            'created_date'     => ['required','date'],
            'latitude'         => ['nullable','numeric','between:-90,90'],
            'longitude'        => ['nullable','numeric','between:-180,180'],
            'tested_count'     => ['required','integer','min:0'],
            'last_calibration' => ['required','date'],
            'status'           => ['required','integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'pi_mac_address.regex' => 'รูปแบบ MAC address ไม่ถูกต้อง (ตัวอย่าง: AA:BB:CC:DD:EE:FF)',
        ];
    }


}
