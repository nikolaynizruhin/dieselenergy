@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('category.update') }}
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.categories.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
