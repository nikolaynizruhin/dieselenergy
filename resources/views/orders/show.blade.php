@extends('layouts.app')

@section('content')
    @include('layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('Order Details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3">{{ __('Status') }}</div>
                <div class="col-md-6">
                    @include('orders.partials.status')
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3">{{ __('Customer') }}</div>
                <div class="col-md-6">
                    <a href="{{ route('customers.edit', $order->customer) }}">
                        {{ $order->customer->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3">{{ __('Total') }}</div>
                <div class="col-md-6">{{ $order->total }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3">{{ __('Notes') }}</div>
                <div class="col-md-6">{{ $order->notes }}</div>
            </div>
        </div>
    </div>

    @include('carts.index')
@endsection
