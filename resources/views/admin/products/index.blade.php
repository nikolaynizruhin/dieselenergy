@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.products.index')])
        </div>
        <div class="col text-right">
            @include('admin.products.partials.add', ['classes' => 'btn-primary shadow-sm mb-3'])
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.products.partials.'.($products->total() ? 'list' : 'empty'))
    </div>
@endsection