@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('attribute.update') }}
        </div>

        <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.attributes.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
