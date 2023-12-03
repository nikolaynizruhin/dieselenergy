@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('brand.add') }}
        </div>

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf
            @include('admin.brands.partials.form')
        </form>
    </div>
@endsection
