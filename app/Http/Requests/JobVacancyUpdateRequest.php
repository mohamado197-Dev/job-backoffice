<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'company_id' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
          'title.required' => 'Job Title is required',
          'title.string' => 'Job Title must be a string',
          'title.max' => 'Job Title must be less than 255 characters',
          'location.required' => 'Location is required',
          'location.string' => 'Location must be a string',
          'location.max' => 'Location must be less than 255 characters',
          'salary.required' => 'Expected Salary is required',
          'salary.string' => 'Expected Salary must be a string',
          'salary.max' => 'Expected Salary must be less than 255 characters',
          'type.required' => 'Job Type is required',
          'type.string' => 'Job Type must be a string',
          'type.max' => 'Job Type must be less than 255 characters',
          'category_id.required' => 'Job Category is required',
          'category_id.string' => 'Job Category must be a string',
          'category_id.max' => 'Job Category must be less than 255 characters',
          'company_id.required' => 'Company is required',
          'company_id.string' => 'Company must be a string',
          'company_id.max' => 'Company must be less than 255 characters',
          'description.required' => 'Description is required',
          'description.string' => 'Description must be a string',
          'description.max' => 'Description must be less than 255 characters',
        ];
    }
}
