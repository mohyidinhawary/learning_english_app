<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            'experience' => 'required|in:ضعيفة,عادية,جيدة,ممتازة',
            'easy_to_understand' => 'required|in:لا,أحياناً,نعم',
            'continue_next_level' => 'required|in:لا,ربما لاحقاً,نعم',
        ];
    }
}
