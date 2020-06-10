@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('cart.update') }}
        </div>

        <form action="{{ route('admin.carts.update', $cart) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Order -->
                <div class="form-group row">
                    <label for="selectOrder" class="col-md-3 col-form-label">{{ __('cart.ordered_by') }}</label>
                    <div class="col-md-6">
                        <select id="selectOrder"
                                class="form-control @error('order_id') is-invalid @enderror"
                                name="order_id"
                                required>
                            <option value="{{ $cart->order_id }}" selected>
                                {{ $cart->order->customer->email }}
                            </option>
                        </select>

                        @error('order_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Product -->
                <div class="form-group row">
                    <label for="selectProduct" class="col-md-3 col-form-label">{{ __('product.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectProduct"
                                class="form-control @error('product_id') is-invalid @enderror"
                                name="product_id"
                                required>
                            <option value="">{{ __('product.select') }}</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @if (old('product_id', $cart->product_id) == $product->id) selected @endif>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('product_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Quantity -->
                <div class="form-group row">
                    <label for="inputQuantity" class="col-md-3 col-form-label">{{ __('common.quantity') }}</label>
                    <div class="col-md-6">
                        <input type="number" id="inputQuantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $cart->quantity) }}" required min="1">

                        @error('quantity')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
