@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('brand.update') }}
        </div>

        <form action="{{ route('admin.brands.update', $brand) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.brands.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
