@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('customer.add') }}
        </div>

        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            @include('admin.customers.partials.form')
        </form>
    </div>
@endsection
