@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            @if($unit->id)
                                {{ __('Edit Unit') }}
                            @else
                                {{ __('Create Unit') }}
                            @endif

                        </h3>
                    </div>

                    <div class="card-actions">
                        <x-action.close route="{{ route('units.index') }}"/>
                    </div>
                </div>

                <form action="{{ ! $unit->id ? route('units.store') : route('units.update', $unit) }}" method="POST">
                    @if($unit->id)
                        @method('PUT')
                    @endif

                    @csrf
                    <div class="card-body">
                        <x-input
                            label="{{ __('Unit Name') }}"
                            id="name"
                            name="name"
                            :value="old('name', $unit->name)"
                            required
                        />

                        <x-input
                            label="{{ __('Short Code') }}"
                            id="short_code"
                            name="short_code"
                            :value="old('short_code', $unit->short_code)"
                            required
                        />
                    </div>
                    <div class="card-footer text-end">
                        <x-button type="submit">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
