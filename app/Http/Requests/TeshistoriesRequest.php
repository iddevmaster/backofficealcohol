<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeshistoriesRequest extends FormRequest
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
            'tester_id'       => ['required','string','max:191'],
            'device_sn'       => ['nullable','string','max:191'],
            'testing_image'       => ['nullable','string','max:191'],
            'alcohol_level'         => ['nullable','numeric','between:1,10000'],
            'org_id'       => ['required','string','max:191'],
        ];
    }
}
