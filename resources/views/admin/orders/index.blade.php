@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.orders.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create') }}" role="button">{{ __('order.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @includeWhen($orders->isNotEmpty(), 'admin.orders.partials.list', [
            'route' => ['name' => 'admin.orders.index', 'parameters' => []],
        ])
        @includeWhen($orders->isEmpty(), 'admin.layouts.partials.empty', [
            'body' => __('order.missing'),
            'link' => route('admin.orders.create'),
            'button' => __('order.add'),
        ])
    </div>
@endsection
