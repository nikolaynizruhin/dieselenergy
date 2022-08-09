@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.update') }}
            <a class="float-end" href="{{ route('admin.posts.show', $post) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            @include('admin.posts.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
