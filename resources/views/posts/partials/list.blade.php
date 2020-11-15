@foreach ($posts->chunk(3) as $chunkedPosts)
    <div class="card-deck">
        @foreach ($chunkedPosts as $post)
            <div class="card shadow-sm">
                <img src="{{ asset('storage/'.$post->image->path) }}" class="card-img-top" alt="{{ $post->title }}">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('posts.show', $post) }}" class="text-body text-decoration-none stretched-link">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="card-text text-muted">{{ $post->excerpt }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
<br>
<div class="row">
    <div class="col">
        {{ $posts->links('layouts.partials.pagination') }}
    </div>
</div>
