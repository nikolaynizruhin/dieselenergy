@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('category.details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.name') }}</div>
                <div class="col-md-9">{{ $category->name }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.slug') }}</div>
                <div class="col-md-9">{{ $category->slug }}</div>
            </div>
        </div>
    </div>

    @include('admin.specifications.index')
@endsection
