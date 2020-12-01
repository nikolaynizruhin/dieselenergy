@extends('layouts.app')

@section('title', 'Кошик')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <h2 class="text-center">Ваше замовлення</h2>
            <h5 class="text-center text-muted">Наш консультант зв'яжеться з Вами для уточнення деталей</h5>
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

    @includeWhen($items->isNotEmpty(), 'layouts.partials.services')
@endsection
