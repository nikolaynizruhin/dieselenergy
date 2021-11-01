@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('customer.update') }}
        </div>

        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.customers.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
