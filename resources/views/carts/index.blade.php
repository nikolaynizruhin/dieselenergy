@extends('layouts.app')

@section('title', 'Кошик')

@push('meta')
    <meta name="robots" content="noindex, follow">
@endpush

@section('content')
    <section class="py-5">

        <div class="container position-relative">
            <div class="dots top-0 end-0 height-72 width-48 position-absolute z-n1"></div>

            <h2 class="text-center">Ваше замовлення</h2>
            <h5 class="text-center text-muted">Наш консультант зв'яжеться з Вами для уточнення деталей</h5>
            <br>
            @if($items->isNotEmpty())
                <div class="row">
                    <div class="col-lg-8">
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
