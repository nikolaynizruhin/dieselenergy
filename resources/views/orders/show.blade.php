@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-64 width-40 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4 text-gray-500">
                <div class="col letter-spacing d-flex align-items-center">
                    Shop
                    @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                    Order Confirmation
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6 py-5 text-center">
                    @include('layouts.partials.icon', ['name' => 'check-circle', 'classes' => 'text-success mb-3', 'width' => '4em', 'height' => '4em'])
                    <h2>Вітаємо.</h2>
                    <h4>Ваше замовлення прийнято.</h4>
                    <p class="text-muted">На Вашу пошту буде відправлено деталі замовлення!<br>Наш консультант зв'яжеться з Вами найближчим часом для уточнення деталей.</p>
                    <p class="text-muted">Номер замовлення: <strong>{{ $order->id }}</strong></p>
                </div>
            </div>
        </div>
    </section>
@endsection
