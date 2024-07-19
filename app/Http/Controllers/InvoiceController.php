<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceRequest;
use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;

class InvoiceController extends Controller
{
    public function create(InvoiceRequest $request)
    {
        $customer = Customer::findOrFail($request->get('customer_id'));

        $carts = Cart::content();

        return view('invoices.create', [
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}
