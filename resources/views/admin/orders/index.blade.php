@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.orders.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create') }}" role="button">{{ __('order.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.orders.partials.'.($orders->isEmpty() ? 'empty' : 'list'), [
            'route' => ['name' => 'admin.orders.index', 'parameters' => []],
        ])
    </div>
@endsection
