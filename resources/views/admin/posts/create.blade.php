@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.add') }}
        </div>

        <form action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @include('admin.posts.partials.form')
        </form>
    </div>
@endsection
