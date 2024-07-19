<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use App\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            case 'POST':
            {
                return [
                    'role' => ['required', 'integer', new EnumValue(UserRole::class)],
                    'name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'personal_id' => 'required|max:255|min:6|unique:users,personal_id',
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'nullable|min:6',
                    //'password_confirmation' => 'same:password|min:6',
                    'store_name' => 'nullable|string|max:255',
                    'store_address' => 'nullable|string|max:255',
                    'store_phone' => 'nullable|string|max:255',
                    'store_email' => 'nullable|string|max:255',
                    'photo' => 'nullable|image|file|max:1024',
                ];
            }
            case 'PUT':
            {
                return [
                    'role' => ['integer', new EnumValue(UserRole::class)],
                    'name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'personal_id' => [
                        'required',
                        'max:255',
                        'min:6',
                        Rule::unique('users', 'personal_id')->ignore($this->user),
                    ],
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users', 'email')->ignore($this->user),
                    ],
                    'password' => 'nullable|min:6',
                    //'password_confirmation' => 'same:password|min:6',
                    'store_name' => 'nullable|string|max:255',
                    'store_address' => 'nullable|string|max:255',
                    'store_phone' => 'nullable|string|max:255',
                    'store_email' => 'nullable|string|max:255',
                    'photo' => 'image|file|max:1024',
                ];
            }
        }
    }
}
