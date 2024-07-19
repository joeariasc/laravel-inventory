@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        @if($user->id)
                            {{ __('Edit User') }}
                        @else
                            {{ __('Create User') }}
                        @endif
                    </h2>
                </div>
            </div>
            @if($user->id)
                @include('partials._breadcrumbs', ['model' => $user])
            @else
                @include('partials._breadcrumbs')
            @endif
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <form action="{{ ! $user->id ? route('users.store') : route('users.update', $user) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @if($user->id)
                        @method('PUT')
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row row-cards">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title">
                                                {{ __('User Image') }}
                                            </h3>

                                            <img class="img-account-profile rounded-circle mb-2"
                                                 src="{{ $user->pathAttachment() }}"
                                                 alt="" id="image-preview"/>

                                            <div class="small font-italic text-muted mb-2">JPG or PNG no larger than 1
                                                MB
                                            </div>

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
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="row row-cards">
                                <div class="col-12">

                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 class="card-title">
                                                    {{ __('User Details') }}
                                                </h3>
                                            </div>
                                            <div class="card-actions">
                                                <x-action.close route="{{ route('users.index') }}"/>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="row row-cards">
                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="name" :value="old('name', $user->name)"
                                                             required="true"/>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="last_name"
                                                             :value="old('last_name', $user->last_name)"
                                                             label="Last Name" required="true"/>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="personal_id"
                                                             :value="old('personal_id', $user->personal_id)"
                                                             label="Personal ID" required="true"/>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="email" :value="old('email', $user->email)"
                                                             label="Email address" required="true"/>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <label for="role" class="form-label required">
                                                        {{ __('Role') }}
                                                    </label>

                                                    <select class="form-select @error('role') is-invalid @enderror"
                                                            id="role" name="role">
                                                        <option selected="" disabled="">Select a role:</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->value}}"
                                                                    @if(old('role', $user->role) == $role) selected="selected" @endif>
                                                                {{ $role->label()  }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('role')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <x-input type="password" name="password"/>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="store_name"
                                                             :value="old('store_name', $user->store_name)"
                                                             label="Store Name"/>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="store_address"
                                                             :value="old('store_address', $user->store_address)"
                                                             label="Store Address"/>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="store_phone"
                                                             :value="old('store_phone', $user->store_phone)"
                                                             label="Store Phone"/>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <x-input name="store_email"
                                                             :value="old('store_email', $user->store_email)"
                                                             label="Store Email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Save') }}
                                            </button>

                                            <a class="btn btn-outline-warning" href="{{ route('users.index') }}">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="col-12">
                                    <form action="{{ route('users.updatePassword', $user) }}" method="POST">
                                        @csrf
                                        @method('put')

                                        <div class="card">
                                            <div class="card-body">
                                                <h3 class="card-title">
                                                    {{ __('Change Password') }}
                                                </h3>

                                                <div class="row row-cards">
                                                    <div class="col-sm-6 col-md-6">
                                                        <x-input type="password" name="password"/>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6">
                                                        <x-input type="password" name="password_confirmation"
                                                                 label="Password Confirmation"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer text-end">
                                                --}}{{--- onclick="return confirm('Do you want to change the password?')" ---}}{{--
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Save') }}
                                                </button>

                                                <a class="btn btn-outline-warning" href="{{ route('users.index') }}">
                                                    {{ __('Cancel') }}
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>--}}
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
