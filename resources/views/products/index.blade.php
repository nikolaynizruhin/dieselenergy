@extends('layouts.app')

@section('content')

    @include('layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="form-group">
                    <label for="search" class="sr-only">{{ __('Search') }}</label>
                    <input type="text" name="search" class="form-control shadow-sm" value="{{ request('search') }}" id="search" aria-describedby="search" placeholder="Search">
                </div>
            </form>
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('products.create') }}" role="button">{{ __('Add Product') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('products.partials.'.($products->total() ? 'list' : 'empty'))
    </div>
@endsection
