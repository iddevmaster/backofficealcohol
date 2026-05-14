<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreScanRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'device_id'     => ['required', 'string', 'max:191'],
            'employee_id'   => ['required', 'string', 'max:191'],
            'scan_type'     => ['required', 'string', 'in:alcohol,fingerprint,identification'],
            'result'        => ['required', 'string', 'in:pass,fail,match,no_match,identified'],
            'value'         => ['nullable', 'numeric', 'min:0'],
            'scanned_at'    => ['required', 'date'],
            'testing_image' => ['nullable', 'image', 'max:10240'], // Optional, specifically for alcohol type
        ];
    }

    /**
     * Return JSON error response instead of redirect on validation failure.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
