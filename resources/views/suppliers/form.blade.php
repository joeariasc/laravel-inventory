@extends('layouts.tabler')

@section('content')
    @if(!$supplier->id)
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <h2 class="page-title">
                            {{ __('Create Supplier') }}
                        </h2>
                    </div>
                </div>

                @include('partials._breadcrumbs')
            </div>
        </div>
    @endif

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <form action="{{ ! $supplier->id ? route('suppliers.store') : route('suppliers.update', $supplier) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @if ($supplier->id)
                        @method('PUT')
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Profile Image') }}
                                    </h3>

                                    <img class="img-account-profile mb-2"
                                         src="{{ $supplier->pathAttachment() }}"
                                         alt="" id="image-preview"/>
                                    <!-- Profile picture help block -->
                                    <div class="small font-italic text-muted mb-2">JPG or PNG no larger than 1 MB</div>
                                    <!-- Profile picture input -->
                                    <input
                                        class="form-control form-control-solid mb-2 @error('photo') is-invalid @enderror"
                                        type="file" id="image" name="photo" accept="image/*"
                                        onchange="previewImage();">
                                    @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h3 class="card-title">
                                            @if($supplier->id)
                                                {{ __('Supplier Details') }}
                                            @else
                                                {{ __('Edit Supplier') }}
                                            @endif
                                        </h3>
                                    </div>

                                    <div class="card-actions">
                                        <x-action.close route="{{ route('suppliers.index') }}"/>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-md-12">

                                            <x-input name="name" :value="old('name', $supplier->name)"
                                                     :required="true"/>
                                            <x-input name="email" label="Email address"
                                                     :value="old('email', $supplier->email)" :required="true"/>
                                            <x-input name="shop_name" label="Shop name"
                                                     :value="old('shop_name', $supplier->shop_name)" :required="true"/>
                                            <x-input name="phone" label="Phone number"
                                                     :value="old('phone', $supplier->phone)" :required="true"/>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <label for="type" class="form-label required">
                                                Type of supplier
                                            </label>

                                            <select class="form-select @error('type') is-invalid @enderror" id="type"
                                                    name="type">
                                                <option selected="" disabled>Select a type:</option>
                                                @foreach($supplierType as $type)
                                                    <option value="{{ $type->value }}"
                                                            @if (old('type', $supplier->type) == $type) selected="selected" @endif>
                                                        {{ $type->label() }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <label for="bank_name" class="form-label required">
                                                {{ __('Bank') }}
                                            </label>

                                            <select class="form-select @error('bank') is-invalid @enderror"
                                                    id="bank_name" name="bank_name">
                                                <option selected="" disabled="">Select a bank:</option>
                                                @foreach($colombianBanks as $bank)
                                                    <option value="{{$bank->value}}"
                                                            @if(old('bank', $supplier->bank) == $bank) selected="selected" @endif>
                                                        {{ $bank->label()  }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('bank')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input name="account_holder"
                                                     label="Account holder"
                                                     :value="old('account_holder', $supplier->account_holder)"
                                            />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input name="account_number"
                                                     label="Account number"
                                                     :value="old('account_number', $supplier->account_number)"
                                            />
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label required">
                                                    {{ __('Address ') }}
                                                </label>

                                                <textarea id="address"
                                                          name="address"
                                                          rows="3"
                                                          class="form-control @error('address') is-invalid @enderror"
                                                >{{ old('address', $supplier->address) }}</textarea>

                                                @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <x-button type="submit">
                                        {{ __('Save') }}
                                    </x-button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce
