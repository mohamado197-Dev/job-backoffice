<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'industry' => 'required|string|max:255',

            //owner 
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company Name is required',
            'name.string' => 'Company Name must be a string',
            'name.max' => 'Company Name must be less than 255 characters',
            'name.unique' => 'Company Name must be unique',
            'address.required' => 'Address is required',
            'address.string' => 'Address must be a string',
            'address.max' => 'Address must be less than 255 characters',
            'website.url' => 'Website must be a valid URL',
            'website.max' => 'Website must be less than 255 characters',
            'industry.required' => 'Industry is required',
            'industry.string' => 'Industry must be a string',
            'industry.max' => 'Industry must be less than 255 characters',

            //owner 
            'owner_name.required' => 'Owner Name is required',
            'owner_name.string' => 'Owner Name must be a string',
            'owner_name.max' => 'Owner Name must be less than 255 characters',
            'owner_email.required' => 'Owner Email is required',
            'owner_email.email' => 'Owner Email must be a valid email',
            'owner_email.max' => 'Owner Email must be less than 255 characters',
            'owner_email.unique' => 'Owner Email must be unique',
            'owner_password.required' => 'Owner Password is required',
            'owner_password.string' => 'Owner Password must be a string',
            'owner_password.min' => 'Owner Password must be at least 8 characters',
        ];
    }
}
