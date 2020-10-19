@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4 text-gray-500">
                <div class="col letter-spacing d-flex align-items-center">
                    Shop
                    @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                    Cart
                </div>
            </div>
            <h2 class="text-center">Ваше замовлення</h2>
            <h5 class="text-center text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
            <br>
            @if($items->isNotEmpty())
                <div class="row">
                    <div class="col-lg-8">
                        @include('layouts.partials.alert')
                        @include('carts.partials.list')
                    </div>
                    <div class="col-lg-4">
                        @include('carts.partials.order')
                    </div>
                </div>
            @endif

            @includeWhen($items->isEmpty(), 'carts.partials.empty')
        </div>
    </section>
@endsection
