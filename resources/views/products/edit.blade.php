@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Update Product') }}
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDescription" class="col-md-3 col-form-label">{{ __('Description') }}</label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('email') is-invalid @enderror" id="inputDescription" rows="3">{{ old('description', $product->description) }}</textarea>

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
                        <input type="number" id="inputPrice" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" name="price" required>

                        @error('price')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
@endsection
