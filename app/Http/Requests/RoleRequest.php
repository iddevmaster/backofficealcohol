<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
 public function rules(): array {
    $id = $this->route('roles')?->id;
    $guard = $this->input('guard_name','web');
    return [
      'name' => ['required','string','max:191'],
      'guard_name' => ['required','string','max:50'],
      'org_id' => ['required','integer','min:1'],
      'permissions' => ['sometimes','array'],
      'permissions.*' => ['integer','exists:permissions,id'],
    ];
  }
}
