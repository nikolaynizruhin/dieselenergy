@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.categories.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.categories.create') }}" role="button">{{ __('category.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.categories.partials.'.($categories->isEmpty() ? 'empty' : 'list'))
    </div>
@endsection
