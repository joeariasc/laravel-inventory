<?php

namespace App\Http\Requests\Category;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === UserRole::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            case 'POST':
            {
                return [
                    'name' => [
                        'required',
                        'unique:categories,name'
                    ],
                    'code' => [
                        'required',
                        'unique:categories,code'
                    ]
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => [
                        'required',
                        Rule::unique('categories', 'name')->ignore($this->category)
                    ],
                    'code' => [
                        'required',
                        Rule::unique('categories', 'code')->ignore($this->category)
                    ]
                ];
            }
        }
    }
}
