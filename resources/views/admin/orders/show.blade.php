@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('Order Details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Status') }}</div>
                <div class="col-md-6">
                    <h5 class="m-0 p-0">
                        @include('admin.orders.partials.status')
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Customer') }}</div>
                <div class="col-md-6">
                    <a href="{{ route('admin.customers.edit', $order->customer) }}">
                        {{ $order->customer->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Total') }}</div>
                <div class="col-md-6">@usd($order->total)</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Date') }}</div>
                <div class="col-md-6">{{ $order->created_at }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('Notes') }}</div>
                <div class="col-md-6">{{ $order->notes }}</div>
            </div>
        </div>
    </div>

    @include('admin.carts.index')
@endsection