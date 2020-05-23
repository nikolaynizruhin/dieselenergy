@extends('layouts.app')

@section('content')

    @include('layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            @include('layouts.partials.search', ['url' => route('customers.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('customers.create') }}" role="button">{{ __('Add Customer') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('customers.partials.'.($customers->total() ? 'list' : 'empty'))
    </div>
@endsection
