@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Orders</h6>
                    <h2>{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Customers</h6>
                    <h2>{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Sold Products</h6>
                    <h2>{{ $soldProducts }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @include('layouts.partials.search', ['url' => route('dashboard')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('orders.create') }}" role="button">{{ __('Add Order') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('orders.partials.'.($orders->total() ? 'list' : 'empty'))
    </div>
@endsection
