@extends('layouts.app')

@section('content')
    <div class="container py-5">
        @forelse ($posts->chunk(3) as $chunkedPosts)
            <div class="card-deck">
                @foreach ($chunkedPosts as $post)
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            <p class="card-text"><small class="text-muted">{{ $post->created_at }}</small></p>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p>No posts matched the given criteria.</p>
        @endforelse
    </div>
@endsection
