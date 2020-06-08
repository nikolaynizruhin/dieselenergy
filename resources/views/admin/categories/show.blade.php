@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('category.details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.name') }}</div>
                <div class="col-md-6">{{ $category->name }}</div>
            </div>
        </div>
    </div>

    @include('admin.specifications.index')
@endsection
