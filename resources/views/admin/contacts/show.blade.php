@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 lead">
            {{ __('contact.details') }}
            <a class="float-end" href="{{ route('admin.contacts.edit', $contact) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'pencil', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-muted">{{ __('customer.title') }}</div>
                <div class="col-md-9">
                    <a href="{{ route('admin.customers.edit', $contact->customer) }}">
                        {{ $contact->customer->name }}
                    </a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-9">{{ $contact->created_at->format('Y-m-d H:i') }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('contact.message') }}</div>
                <div class="col-md-9">{{ $contact->message }}</div>
            </div>
        </div>
    </div>
@endsection
