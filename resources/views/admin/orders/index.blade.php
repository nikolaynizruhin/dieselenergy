@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.orders.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create') }}" role="button">{{ __('order.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.orders.partials.'.($orders->total() ? 'list' : 'empty'))
    </div>
@endsection
