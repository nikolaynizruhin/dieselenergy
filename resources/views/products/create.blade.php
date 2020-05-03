@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Add Product') }}
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Name -->
                <div class="form-group row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Brand -->
                <div class="form-group row">
                    <label for="inputBrand" class="col-md-3 col-form-label">{{ __('Brand') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" id="inputBrand" required>
                            <option value="">Select a brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if (old('brand_id') === $brand->id) selected @endif>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('brand_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group row">
                    <label for="inputCategory" class="col-md-3 col-form-label">{{ __('Category') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="inputCategory" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (old('category_id') === $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group row">
                    <label for="inputDescription" class="col-md-3 col-form-label">{{ __('Description') }}</label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('email') is-invalid @enderror" id="inputDescription" rows="3">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPrice" class="col-md-3 col-form-label">{{ __('Price') }}</label>
                    <div class="col-md-6">
                        <input type="number" id="inputPrice" class="form-control @error('price') is-invalid @enderror"  value="{{ old('price') }}"  name="price" required>

                        @error('price')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </form>
    </div>
@endsection
