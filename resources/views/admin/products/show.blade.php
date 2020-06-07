@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('product.details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Name') }}</div>
                <div class="col-md-6">
                    {{ $product->name }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Status') }}</div>
                <div class="col-md-6">
                    <h5 class="m-0 p-0">
                        <span class="badge badge-pill badge-{{ $product->is_active ? 'success' : 'danger' }}">
                            {{ $product->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('brand.title') }}</div>
                <div class="col-md-6">
                    <a href="{{ route('admin.brands.edit', $product->brand) }}">
                        {{ $product->brand->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('category.title') }}</div>
                <div class="col-md-6">
                    <a href="{{ route('admin.categories.edit', $product->category) }}">
                        {{ $product->category->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Price') }}</div>
                <div class="col-md-6">@usd($product->price)</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Description') }}</div>
                <div class="col-md-6">{{ Markdown::parse($product->description) }}</div>
            </div>

            @foreach($product->attributes as $attribute)
                <hr>

                <div class="row">
                    <div class="col-md-3 text-muted">{{ $attribute->name }}</div>
                    <div class="col-md-6">{{ $attribute->pivot->value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    @include('admin.medias.index')
@endsection
