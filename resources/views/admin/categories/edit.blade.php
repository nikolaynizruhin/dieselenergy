@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('category.update') }}
            <a class="float-end" href="{{ route('admin.categories.show', $category) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.categories.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
