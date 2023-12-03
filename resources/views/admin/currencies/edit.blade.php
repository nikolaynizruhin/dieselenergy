@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('currency.update') }}
        </div>

        <form action="{{ route('admin.currencies.update', $currency) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.currencies.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
