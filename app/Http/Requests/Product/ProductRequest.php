<?php

namespace App\Http\Requests\Product;

use App\Enums\UserRole;
use App\Rules\Ean8;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
                    'name' => 'required|string',
                    'barcode' => ['required', 'digits:8', new Ean8],
                    'category_id' => [
                        'required',
                        'uuid',
                        Rule::exists('categories', 'id'),
                    ],
                    'unit_id' => [
                        'required',
                        'uuid',
                        Rule::exists('units', 'id'),],
                    'quantity' => 'required|integer',
                    'buying_price' => 'required|integer',
                    'selling_price' => 'required|integer',
                    'quantity_alert' => 'required|integer',
                    'tax' => 'nullable|numeric',
                    'tax_type' => 'nullable|integer',
                    'notes' => 'nullable|max:1000',
                    'product_image' => 'nullable|image|file|max:2048|mimes:jpg,jpeg,png',
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => 'required|string',
                    'barcode' => ['required', 'digits:8', new Ean8],
                    'category_id' => [
                        'required',
                        'uuid',
                        Rule::exists('categories', 'id'),
                    ],
                    'unit_id' => [
                        'required',
                        'uuid',
                        Rule::exists('units', 'id'),],
                    'quantity' => 'required|integer',
                    'buying_price' => 'required|integer',
                    'selling_price' => 'required|integer',
                    'quantity_alert' => 'required|integer',
                    'tax' => 'nullable|numeric',
                    'tax_type' => 'nullable|integer',
                    'notes' => 'nullable|max:1000',
                    'product_image' => 'nullable|image|file|max:2048|mimes:jpg,jpeg,png',
                ];
            }
        }

    }

    /**
     * Get custom error messages for specific validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'barcode.ean8' => 'The barcode must be a valid EAN-8 code.',
        ];
    }
}
