@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.total.order') }}</h6>
                    <div class="row">
                        <div class="col">
                            <h2>{{ $orders->total() }}</h2>
                        </div>
                        <div class="col text-muted text-right">
                            @include('layouts.partials.icon', ['name' => 'basket', 'width' => '2em', 'height' => '2em'])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.total.customer') }}</h6>
                    <div class="row">
                        <div class="col">
                            <h2>{{ $totalCustomers }}</h2>
                        </div>
                        <div class="col text-muted text-right">
                            @include('layouts.partials.icon', ['name' => 'people', 'width' => '2em', 'height' => '2em'])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.sold_product') }}</h6>
                    <div class="row">
                        <div class="col">
                            <h2>{{ $soldProducts }}</h2>
                        </div>
                        <div class="col text-muted text-right">
                            @include('layouts.partials.icon', ['name' => 'cart3', 'width' => '2em', 'height' => '2em'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.dashboard')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create') }}" role="button">{{ __('order.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.orders.partials.'.($orders->isEmpty() ? 'empty' : 'list'), [
            'route' => ['name' => 'admin.dashboard', 'params' => []],
            'nested' => null,
        ])
    </div>
@endsection
