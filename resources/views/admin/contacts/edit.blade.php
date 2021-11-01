@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('contact.update') }}
        </div>

        <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.contacts.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
