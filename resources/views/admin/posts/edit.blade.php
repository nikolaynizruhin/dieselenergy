@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.update') }}
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            @include('admin.posts.partials.form', ['button' => __('common.update')])
        </form>
    </div>
@endsection
