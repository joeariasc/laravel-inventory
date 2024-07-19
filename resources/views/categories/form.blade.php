@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            @if($category->id)
                                {{ __('Edit Category') }}
                            @else
                                {{ __('Create Category') }}
                            @endif
                        </h3>
                    </div>

                    <div class="card-actions">
                        <x-action.close route="{{ route('categories.index') }}"/>
                    </div>
                </div>
                <form action="{{ ! $category->id ? route('categories.store') :route('categories.update', $category) }}"
                      method="POST">

                    @if ($category->id)
                        @method('PUT')
                    @endif

                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label required">
                                {{ __('Name') }}
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   placeholder="Enter Category name"
                                   value="{{ old('name', $category->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                            />

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label required">
                                {{ __('Code') }}
                            </label>

                            <input type="text"
                                   id="code"
                                   name="code"
                                   placeholder="Enter Category code"
                                   value="{{ old('name', $category->code)  }}"
                                   class="form-control @error('code') is-invalid @enderror"
                            />

                            @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">

                            @if($category->id)
                                {{__('Update')}}
                            @else
                                {{__('Save')}}
                            @endif

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script>
        // Slug Generator
        const title = document.querySelector("#name");
        const slug = document.querySelector("#slug");
        title.addEventListener("keyup", function () {
            let preslug = title.value;
            preslug = preslug.replace(/ /g, "-");
            slug.value = preslug.toLowerCase();
        });
    </script>
@endpushonce
