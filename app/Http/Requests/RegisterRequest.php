<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name"=>"required|string",
             'email' => 'required|email',
            "password" => [
            "required",
            "string",
            "confirmed",
            "min:8",
            "regex:/[a-z]/",      // على الأقل حرف صغير
            "regex:/[A-Z]/",      // على الأقل حرف كبير
            "regex:/[0-9]/",      // على الأقل رقم
           ],
        ];
    }
}
