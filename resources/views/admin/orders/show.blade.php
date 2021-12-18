@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('order.details') }}
            <a class="float-end" href="{{ route('admin.orders.edit', $order) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'pencil', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.number') }}</div>
                <div class="col-md-9">{{ $order->id }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.status') }}</div>
                <div class="col-md-9">
                    <h5 class="m-0 p-0">
                        @include('admin.layouts.partials.status', ['status' => $order->status->value, 'type' => $order->status->badge()])
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
                <div class="col-md-9">@uah($order->total)</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-9">{{ $order->created_at->format('Y-m-d H:i') }}</div>
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
