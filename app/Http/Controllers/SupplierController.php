<?php

namespace App\Http\Controllers;

use App\Enums\ColombianBanks;
use App\Enums\SupplierType;
use App\Helpers\Utilities;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        return view('suppliers.form', [
            'supplier' => new Supplier(),
            'supplierType' => SupplierType::cases(),
            'colombianBanks' => ColombianBanks::cases(),
        ]);
    }

    public function store(SupplierRequest $request)
    {
        if ($request->hasFile('photo')) {
            $image = Utilities::uploadFile('photo', '/public/suppliers');
            $request->merge(['photo' => $image]);
        }

        $request->merge(['user_id' => auth()->id()]);

        Supplier::create($request->input());

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'New supplier has been created!');
    }

    public function show(Supplier $supplier)
    {
        $supplier->loadMissing('purchases')->get();

        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.form', [
            'supplier' => $supplier,
            'supplierType' => SupplierType::cases(),
            'colombianBanks' => ColombianBanks::cases(),
        ]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        if ($request->hasFile('photo')) {
            // Delete the old photo if exists
            Utilities::deleteFile('/public/suppliers', $supplier->photo);
            $image = Utilities::uploadFile('photo', '/public/suppliers');
            $request->merge(['photo' => $image]);
        }

        $supplier->fill($request->input())->save();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been updated!');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Supplier has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Failed try to delete the supplier');
        }
    }
}
