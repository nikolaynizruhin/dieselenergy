@extends('layouts.app')

@section('content')
    <div class="container py-5">
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
                <h2>Congratulations.<br>Your order is accepted.</h2>
                <p class="text-muted">Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
                <p class="text-muted">Your order number: <strong>{{ $order->id }}</strong></p>
            </div>
        </div>
    </div>
@endsection
