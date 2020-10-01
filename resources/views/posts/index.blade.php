@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="col d-flex justify-content-center flex-column mb-5">
            <div class="text-center">
                <h2>From The Blog</h2>
                <h5 class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
            </div>
        </div>
        @forelse ($posts->chunk(3) as $chunkedPosts)
            <div class="card-deck">
                @foreach ($chunkedPosts as $post)
                    <div class="card shadow">
                        <img src="{{ asset('storage/'.$post->image->path) }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none stretched-link">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text">{{ $post->excerpt }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <small class="text-muted">{{ $post->created_at }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p>No posts matched the given criteria.</p>
        @endforelse
        <div class="row">
            <div class="col offset-md-3 offset-lg-2">
                {{ $posts->links('layouts.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
