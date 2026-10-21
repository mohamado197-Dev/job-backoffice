<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
        // dd($this->route('company')); used to avoid update data to be the same name  
        return [
            'status' => 'bail|required|in:pending,accepted,rejected',
        ];
    }

    public function messages(): array
    {
        return [
          'status.required' => 'Status is required',
          'status.in' => 'Status must be either pending, accepted, or rejected',
        ];
    }
}
