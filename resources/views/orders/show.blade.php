@extends('layouts.app')

@section('title', 'Замовлення')

@push('meta')
    <meta name="robots" content="noindex, follow">
@endpush

@section('content')
    <section class="py-5">
        <div class="container position-relative">
            <div class="dots top-0 end-0 height-64 width-40 position-absolute d-none d-md-block z-n1"></div>

            <div class="row justify-content-center">
                <div class="col col-md-6 py-5 text-center">
                    @include('layouts.partials.icon', ['name' => 'check-circle', 'classes' => 'text-success mb-3', 'width' => '3.5em', 'height' => '3.5em'])
                    <h2>Вітаємо!</h2>
                    <h4>Ваше замовлення прийнято.</h4>
                    <p class="my-3 text-muted">Номер замовлення: <strong class="text-body">#{{ $order->id }}</strong></p>
                    <p class="text-muted">На Вашу пошту буде відправлено інформацію про замовлення. Наш консультант зв'яжеться з Вами найближчим часом для уточнення деталей.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
