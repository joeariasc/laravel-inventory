<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method) {
            case 'GET':
            case 'DELETE':
            case 'PUT':
            case 'POST':
            {
                return [
                    'customer_id' => [
                        'required',
                        'uuid',
                        Rule::exists('customers', 'id'),
                    ],
                    'payment_type' => 'required',
                    'pay' => 'required|numeric'
                ];
            }
        }
    }

}
