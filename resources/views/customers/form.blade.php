@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        @if( $customer->id)
                            {{ __('Edit Customer') }}
                        @else
                            {{ __('Create Customer') }}
                        @endif
                    </h2>
                </div>
            </div>
            @if( $customer->id)
                @include('partials._breadcrumbs', ['model' => $customer])
            @else
                @include('partials._breadcrumbs')
            @endif
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <form action="{{ ! $customer->id ? route('customers.store') : route('customers.update', $customer) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @if ($customer->id)
                        @method('PUT')
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Customer Image') }}
                                    </h3>

                                    <img class="img-account-profile mb-2"
                                         src="{{ $customer->pathAttachment() }}"
                                         alt="" id="image-preview"/>

                                    <div class="small font-italic text-muted mb-2">JPG or PNG no larger than 2 MB</div>

                                    <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                           id="image" name="photo" accept="image/*" onchange="previewImage();">

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
                                            @if( $customer->id)
                                                {{ __('Edit Customer') }}
                                            @else
                                                {{ __('Customer Details') }}
                                            @endif

                                        </h3>
                                    </div>

                                    <div class="card-actions">
                                        <x-action.close route="{{ route('customers.index') }}"/>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-md-12">
                                            <x-input name="name" :value="old('name', $customer->name)"
                                                     :required="true"/>

                                            <x-input label="Email address" name="email"
                                                     :value="old('email', $customer->email)"
                                                     :required="true"/>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Phone number" name="phone"
                                                     :value="old('phone', $customer->phone)"
                                                     :required="true"/>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <label for="bank_name" class="form-label">
                                                {{ __('Bank') }}
                                            </label>

                                            <select class="form-select @error('bank') is-invalid @enderror"
                                                    id="bank" name="bank">
                                                <option selected="" disabled>Select a bank:</option>
                                                @foreach($colombianBanks as $bank)
                                                    <option value="{{$bank->value}}"
                                                            @if(old('bank', $customer->bank) == $bank) selected="selected" @endif>
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
                                            <x-input label="Account holder" name="account_holder"
                                                     :value="old('account_holder', $customer->account_holder)"
                                                     :required="true"/>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Account number" name="account_number"
                                                     :value="old('account_number', $customer->account_number)"
                                                     :required="true"/>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label required">
                                                    {{ __('Address') }}
                                                </label>

                                                <textarea id="address" name="address" rows="3"
                                                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>

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
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Save') }}
                                    </button>

                                    <a class="btn btn-outline-warning" href="{{ route('customers.index') }}">
                                        {{ __('Cancel') }}
                                    </a>
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
