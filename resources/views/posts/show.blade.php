@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>{{ $post->title }}</h1>
        <hr>
        @markdown($post->body)
        <small class="text-muted">{{ $post->created_at }}</small>
    </div>
@endsection
