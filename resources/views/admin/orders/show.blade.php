@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('order.details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.status') }}</div>
                <div class="col-md-9">
                    <h5 class="m-0 p-0">
                        @include('admin.orders.partials.status')
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('customer.title') }}</div>
                <div class="col-md-9">
                    <a href="{{ route('admin.customers.edit', $order->customer) }}">
                        {{ $order->customer->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.total') }}</div>
                <div class="col-md-9">@usd($order->total)</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-9">{{ $order->created_at }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.notes') }}</div>
                <div class="col-md-9">{{ $order->notes }}</div>
            </div>
        </div>
    </div>

    @include('admin.carts.index')
@endsection
