@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.alert')

    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('contact.details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('customer.title') }}</div>
                <div class="col-md-6">
                    <a href="{{ route('admin.customers.edit', $contact->customer) }}">
                        {{ $contact->customer->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('contact.subject') }}</div>
                <div class="col-md-6">{{ $contact->subject }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-6">{{ $contact->created_at }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('contact.message') }}</div>
                <div class="col-md-6">{{ $contact->message }}</div>
            </div>
        </div>
    </div>
@endsection