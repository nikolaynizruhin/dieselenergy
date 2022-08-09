@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('customer.update') }}
            <a class="float-end" href="{{ route('admin.customers.show', $customer) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>

        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.customers.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
