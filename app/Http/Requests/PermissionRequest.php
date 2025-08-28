<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array {
    $id = $this->route('permission')?->id;
    $guard = $this->input('guard_name','web');
    return [
      'name' => ['required','string','max:191',
        Rule::unique('permissions')->ignore($id)->where(fn($q)=>$q->where('guard_name',$guard))
      ],
      'guard_name' => ['required','string','max:50'],
    ];
  }
}
