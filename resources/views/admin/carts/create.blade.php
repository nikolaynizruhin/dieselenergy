@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('cart.add') }}
        </div>

        <form action="{{ route('admin.carts.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Order -->
                <div class="mb-3 row">
                    <label for="selectOrder" class="col-md-3 col-form-label">{{ __('cart.ordered_by') }}</label>
                    <div class="col-md-6">
                        <select id="selectOrder"
                                class="form-select @error('order_id') is-invalid @enderror"
                                name="order_id"
                                required>
                            <option value="{{ $order->id }}" selected>
                                {{ $order->customer->email }}
                            </option>
                        </select>

                        @include('layouts.partials.error', ['name' => 'order_id'])
                    </div>
                </div>

                <!-- Product -->
                <div class="mb-3 row">
                    <label for="selectProduct" class="col-md-3 col-form-label">{{ __('product.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectProduct"
                                class="form-select @error('product_id') is-invalid @enderror"
                                name="product_id"
                                required>
                            <option value="">{{ __('product.select') }}</option>
                            @foreach ($products as $product)
                                @unless ($order->products->contains($product))
                                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                        {{ $product->name }}
                                    </option>
                                @endunless
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'product_id'])
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-3 row">
                    <label for="inputQuantity" class="col-md-3 col-form-label">{{ __('common.quantity') }}</label>
                    <div class="col-md-6">
                        <input type="number" id="inputQuantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', 1) }}" required min="1">

                        @include('layouts.partials.error', ['name' => 'quantity'])
                    </div>
                </div>
            </div>

            <div class="card-footer text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
