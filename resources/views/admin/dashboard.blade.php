@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.total.order') }}</h6>
                        <div class="row">
                            <div class="col">
                                <h2>{{ $orders->total() }}</h2>
                            </div>
                            <div class="col text-muted text-end">
                                @include('layouts.partials.icon', ['name' => 'basket', 'width' => '2em', 'height' => '2em'])
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.total.customer') }}</h6>
                        <div class="row">
                            <div class="col">
                                <h2>{{ $totalCustomers }}</h2>
                            </div>
                            <div class="col text-muted text-end">
                                @include('layouts.partials.icon', ['name' => 'people', 'width' => '2em', 'height' => '2em'])
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ __('dashboard.sold_product') }}</h6>
                        <div class="row">
                            <div class="col">
                                <h2>{{ $soldProducts }}</h2>
                            </div>
                            <div class="col text-muted text-end">
                                @include('layouts.partials.icon', ['name' => 'cart3', 'width' => '2em', 'height' => '2em'])
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.dashboard')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create') }}" role="button">{{ __('order.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @if ($orders->isEmpty())
            @include('admin.layouts.partials.empty', [
                'body' => __('order.missing'),
                'link' => route('admin.orders.create'),
                'button' => __('order.add'),
            ])
        @else
            @include('admin.orders.partials.list', [
                'route' => ['name' => 'admin.dashboard', 'parameters' => []],
            ])
        @endif
    </div>
@endsection
