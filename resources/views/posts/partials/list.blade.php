@foreach ($posts->chunk(3) as $chunkedPosts)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($chunkedPosts as $post)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/'.$post->image->path) }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy">
                    <div class="card-body">
                        <h3 class="card-title h5">
                            <a href="{{ route('posts.show', $post) }}" class="text-body text-decoration-none stretched-link">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="card-text text-muted">{{ $post->excerpt }}</p>
                    </div>
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
