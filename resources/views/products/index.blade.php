@extends('layouts.app')

@section('content')

    @include('layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            @include('layouts.partials.search', ['url' => route('products.index')])
        </div>
        <div class="col text-right">
            @include('products.partials.add', ['classes' => 'btn-primary shadow-sm mb-3'])
        </div>
    </div>

    <div class="card shadow-sm">
        @include('products.partials.'.($products->total() ? 'list' : 'empty'))
    </div>
@endsection
