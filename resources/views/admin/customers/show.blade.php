@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 lead">
            {{ __('customer.details') }}
            <a class="float-end" href="{{ route('admin.customers.edit', $customer) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'pencil', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('customer.title') }}</div>
                <div class="col-md-9">{{ $customer->name }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.email') }}</div>
                <div class="col-md-9">{{ $customer->email }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.phone') }}</div>
                <div class="col-md-9">{{ $customer->phone }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.notes') }}</div>
                <div class="col-md-9">{{ $customer->notes }}</div>
            </div>
        </div>
    </div>

    @include('admin.customers.orders.index')
    @include('admin.customers.contacts.index')
@endsection
