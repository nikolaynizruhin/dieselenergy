@extends('layouts.app')

@section('content')

    @include('layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            @include('layouts.partials.search', ['url' => route('attributes.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('attributes.create') }}" role="button">{{ __('Add Attribute') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('attributes.partials.'.($attributes->total() ? 'list' : 'empty'))
    </div>
@endsection
