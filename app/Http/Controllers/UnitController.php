<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Models\Unit;
use Str;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();

        return view('units.index', [
            'units' => $units,
        ]);
    }

    public function create()
    {
        return view('units.form', [
            'unit' => new Unit(),
        ]);
    }

    public function show(Unit $unit)
    {
        $unit->loadMissing('products')->get();

        return view('units.show', [
            'unit' => $unit
        ]);
    }

    public function store(UnitRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        Unit::create($request->input());

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit has been created!');
    }

    public function edit(Unit $unit)
    {
        return view('units.form', [
            'unit' => $unit
        ]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->fill($request->input())->save();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit has been updated!');
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();

            return redirect()
                ->route('units.index')
                ->with('success', 'Unit has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->route('units.index')
                ->with('success', 'Failed try to delete the unit');
        }

    }
}
