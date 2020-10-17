@foreach ($posts->chunk(3) as $chunkedPosts)
    <div class="card-deck">
        @foreach ($chunkedPosts as $post)
            <div class="card">
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
                    <small class="text-muted">{{ $post->created_at->format('Y-m-d H:i') }}</small>
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
