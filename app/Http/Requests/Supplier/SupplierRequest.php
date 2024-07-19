<?php

namespace App\Http\Requests\Supplier;

use App\Enums\ColombianBanks;
use App\Enums\SupplierType;
use App\Enums\UserRole;
use App\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                    'photo' => 'image|file|max:1024|mimes:jpg,jpeg,png',
                    'name' => 'required|string|max:50',
                    'email' => 'required|email|max:50',
                    'phone' => 'required|string|max:25',
                    'shop_name' => 'required|string|max:50',
                    'type' => ['required', 'integer', new EnumValue(SupplierType::class)],
                    'account_holder' => 'max:50',
                    'account_number' => 'max:25',
                    'bank' => ['string', new EnumValue(ColombianBanks::class)],
                    'address' => 'required|string|max:100',
                ];
            }
            case 'PUT':
            {
                return [
                    'photo' => 'image|file|max:1024|mimes:jpg,jpeg,png',
                    'name' => 'required|string|max:50',
                    'email' => 'required|email|max:50',
                    'phone' => 'required|string|max:25',
                    'shop_name' => 'required|string|max:50',
                    'type' => ['required', 'integer', new EnumValue(SupplierType::class)],
                    'account_holder' => 'max:50',
                    'account_number' => 'max:25',
                    'bank' => ['string', new EnumValue(ColombianBanks::class)],
                    'address' => 'required|string|max:100',
                ];
            }
        }
    }
}