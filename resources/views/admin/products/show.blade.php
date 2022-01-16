@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('product.details') }}
            <a class="float-end" href="{{ route('admin.products.edit', $product) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'pencil', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.name') }}</div>
                <div class="col-md-9">
                    {{ $product->name }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.slug') }}</div>
                <div class="col-md-9">
                    {{ $product->slug }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('product.model') }}</div>
                <div class="col-md-9">
                    {{ $product->model }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.status') }}</div>
                <div class="col-md-9">
                    <h5 class="m-0 p-0">
                        @include('admin.layouts.partials.status', [
                            'status' => $product->is_active ? __('common.active') : __('Inactive'),
                            'type' => $product->is_active ? 'success' : 'danger',
                        ])
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('brand.title') }}</div>
                <div class="col-md-9">
                    <a href="{{ route('admin.brands.edit', $product->brand) }}">
                        {{ $product->brand->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('category.title') }}</div>
                <div class="col-md-9">
                    <a href="{{ route('admin.categories.edit', $product->category) }}">
                        {{ $product->category->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.price') }}</div>
                <div class="col-md-9">{{ $product->price->toUAH()->format() }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.description') }}</div>
                <div class="col-md-9">@markdown($product->description)</div>
            </div>

            @foreach($product->attributes as $attribute)
                <hr>

                <div class="row">
                    <div class="col-md-3 text-muted">{{ $attribute->field }}</div>
                    <div class="col-md-9">{{ $attribute->pivot->value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    @include('admin.medias.index')
@endsection
