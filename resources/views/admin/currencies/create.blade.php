@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('currency.add') }}
        </div>

        <form action="{{ route('admin.currencies.store') }}" method="POST">
            @csrf
            @include('admin.currencies.partials.form')
        </form>
    </div>
@endsection
