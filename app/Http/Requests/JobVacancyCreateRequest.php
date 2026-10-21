<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|integer|min:0',
            'type'        => 'required|in:full-time,contract,hybrid,remote',
            'category_id' => 'required|exists:job_categories,id',
            'company_id'  => 'required|exists:companies,id',
            'description' => 'required|string',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description must be less than 255 characters',
            'salary.required' => 'Salary is required',
            'salary.integer' => 'Salary must be an integer',
            'salary.min' => 'Salary must be at least 0',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be full-time, contract, hybrid, or remote',
            'location.required' => 'Location is required',
            'location.string' => 'Location must be a string',
            'location.max' => 'Location must be less than 255 characters',
            'company_id.required' => 'Company is required',
            'company_id.exists' => 'Company must exist',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category must exist',
        ];
    }
}
