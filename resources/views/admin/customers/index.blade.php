@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.customers.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.customers.create') }}" role="button">{{ __('customer.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.customers.partials.'.($customers->isEmpty() ? 'empty' : 'list'))
    </div>
@endsection
