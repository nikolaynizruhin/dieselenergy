@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.products.index')])
        </div>
        <div class="col text-end">
            @include('admin.products.partials.add', ['classes' => 'btn-primary text-white shadow-sm mb-3'])
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.products.partials.'.($products->isEmpty() ? 'empty' : 'list'))
    </div>
@endsection
