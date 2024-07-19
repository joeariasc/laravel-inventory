<?php

namespace App\Http\Controllers;

use App\Enums\ColombianBanks;
use App\Helpers\Utilities;
use App\Http\Requests\Customer\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return view('customers.form', [
            'customer' => new Customer(),
            'colombianBanks' => ColombianBanks::cases(),
        ]);
    }

    public function store(CustomerRequest $request)
    {
        if ($request->hasFile('photo')) {
            $image = Utilities::uploadFile('photo', '/public/customers');
            $request->merge(['photo' => $image]);
        }

        $request->merge(['user_id' => auth()->id()]);

        Customer::create($request->input());

        return redirect()
            ->route('customers.index')
            ->with('success', 'New customer has been created!');
    }

    public function show(Customer $customer)
    {
        $customer->loadMissing(['quotations', 'orders'])->get();

        return view('customers.show', [
            'customer' => $customer
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.form', [
            'customer' => $customer,
            'colombianBanks' => ColombianBanks::cases(),
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        if ($request->hasFile('photo')) {
            // Delete the old photo if exists
            Utilities::deleteFile('/public/users', $customer->photo);
            $image = Utilities::uploadFile('photo', '/public/customers');
            $request->merge(['photo' => $image]);
        }

        $customer->fill($request->input())->save();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer has been updated!');
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()
                ->back()
                ->with('success', 'Customer has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->back()
                ->with('success', 'Failed try to delete the customer');
        }
    }
}
