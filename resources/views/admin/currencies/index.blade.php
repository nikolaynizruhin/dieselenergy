@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.currencies.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.currencies.create') }}" role="button">{{ __('currency.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @includeWhen($currencies->isNotEmpty(), 'admin.currencies.partials.list')
        @includeWhen($currencies->isEmpty(), 'admin.layouts.partials.empty', [
            'icon' => 'cash-stack',
            'body' => __('currency.missing'),
            'link' => route('admin.currencies.create'),
            'button' => __('currency.add'),
        ])
    </div>
@endsection
