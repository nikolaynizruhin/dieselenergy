@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.customers.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.customers.create') }}" role="button">{{ __('customer.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @if ($customers->isEmpty())
            @include('admin.layouts.partials.empty', [
                'icon' => 'person-plus',
                'body' => __('customer.missing'),
                'link' => route('admin.customers.create'),
                'button' => __('customer.add'),
            ])
        @else
            @include('admin.customers.partials.list', [
                'route' => [
                    'name' => 'admin.customers.index',
                    'parameters' => []
                ],
            ])
        @endif
    </div>
@endsection
