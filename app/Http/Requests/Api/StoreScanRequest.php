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
            'result'        => ['required', 'string', 'in:pass,fail,match,no_match,identified,no_templates,scan_error'],
            'value'         => ['nullable', 'numeric', 'min:0'],
            'scanned_at'    => ['required', 'date'],
            'testing_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $validator = \Illuminate\Support\Facades\Validator::make(
                            [$attribute => $value],
                            [$attribute => 'image|max:10240']
                        );
                        if ($validator->fails()) {
                            $fail($validator->errors()->first($attribute));
                        }
                    } elseif (is_string($value)) {
                        $data = $value;
                        if (preg_match('/^data:image\/(\w+);base64,/', $data, $matches)) {
                            $data = substr($data, strpos($data, ',') + 1);
                        }
                        if (base64_decode($data, true) === false) {
                            $fail('The ' . $attribute . ' must be a valid base64 image string.');
                        }
                    } else {
                        $fail('The ' . $attribute . ' must be an image file or a base64 string.');
                    }
                }
            ], // Optional, specifically for alcohol type
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
