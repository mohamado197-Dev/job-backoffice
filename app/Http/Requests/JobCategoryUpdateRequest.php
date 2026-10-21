<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobCategoryUpdateRequest extends FormRequest
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
        // dd($this->route('job_category')); used to avoid update data to be the same name  
        return [
            'name' => 'required|string|max:255|unique:job_categories,name,'.$this->route('job_category'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category Name is required',
            'name.string' => 'Category Name must be a string',
            'name.max' => 'Category Name must be less than 255 characters',
            'name.unique' => 'Category Name must be unique',
        ];
    }
}
