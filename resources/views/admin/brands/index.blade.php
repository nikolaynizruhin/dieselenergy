@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.brands.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.brands.create') }}" role="button">{{ __('brand.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @includeWhen($brands->isNotEmpty(), 'admin.brands.partials.list')
        @includeWhen($brands->isEmpty(), 'admin.layouts.partials.empty', [
            'body' => __('brand.missing'),
            'link' => route('admin.brands.create'),
            'button' => __('brand.add'),
        ])
    </div>
@endsection
