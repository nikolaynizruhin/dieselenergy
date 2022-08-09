@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('contact.update') }}
            <a class="float-end" href="{{ route('admin.contacts.show', $contact) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>

        <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.contacts.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
