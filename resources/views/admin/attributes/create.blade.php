@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('attribute.add') }}
        </div>

        <form action="{{ route('admin.attributes.store') }}" method="POST">
            @csrf
            @include('admin.attributes.partials.form')
        </form>
    </div>
@endsection
