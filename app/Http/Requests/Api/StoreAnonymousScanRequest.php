<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnonymousScanRequest extends FormRequest
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
            'device_id' => ['required', 'string', 'max:191'],
            'user_id' => ['required', 'string'],
            'scan_type' => ['required', 'string', 'in:alcohol'],
            'result' => ['required', 'string', 'in:pass,fail'],
            'value' => ['required', 'numeric', 'between:0.0,600.0'],
            'scanned_at' => ['required', 'date'],
            'image' => ['nullable', 'string'],
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
            'errors' => $validator->errors(),
        ], 422));
    }
}
