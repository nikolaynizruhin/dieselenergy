@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mt-n3 mb-4 text-gray-500">
            <div class="col letter-spacing d-flex align-items-center">
                Posts
                @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                {{ $post->title }}
            </div>
        </div>
        <h3>{{ $post->title }}</h3>
        @markdown($post->body)
        <small class="text-muted">{{ $post->created_at }}</small>
    </div>
@endsection
