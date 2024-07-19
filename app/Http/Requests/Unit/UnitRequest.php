<?php

namespace App\Http\Requests\Unit;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
                    'name' => 'required|unique:units,name',
                    'short_code' => 'required'
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => 'required|unique:units,name',
                    'short_code' => 'required'
                ];
            }
        }
        return [
            //
        ];
    }
}
