<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emp_id'        => ['required', 'string', 'max:191'],
            'device_sn'     => ['required', 'string', 'max:191'],
            'alcohol_level' => ['required', 'numeric', 'min:0'],
            'testing_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,bmp,webp', 'max:10240'],
            'testing_date'  => ['required', 'date_format:Y-m-d H:i:s'],
            'org_id'        => ['required', 'integer', 'exists:organizations,id'],
        ];
    }

    // Return JSON error response instead of redirect on validation failure
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
