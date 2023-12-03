@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('contact.add') }}
        </div>

        <form action="{{ route('admin.contacts.store') }}" method="POST">
            @csrf
            @include('admin.contacts.partials.form')
        </form>
    </div>
@endsection
