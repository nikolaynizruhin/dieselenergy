@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('category.add') }}
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            @include('admin.categories.partials.form')
        </form>
    </div>
@endsection
