<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ view_modified_date('home') }}</lastmod>
    </url>
    <url>
        <loc>{{ route('privacy') }}</loc>
        <lastmod>{{ view_modified_date('privacy') }}</lastmod>
    </url>
    @for ($page = 1; $page <= $postPages; $page++)
        <url>
            <loc>{{ route('posts.index', $page === 1 ? [] : ['page' => $page]) }}</loc>
            <lastmod>{{ view_modified_date('posts/index') }}</lastmod>
        </url>
    @endfor
    @foreach($categories as $category)
        @for ($page = 1; $page <= $category->productPages(); $page++)
            <url>
                <loc>{{ route('categories.products.index', $page === 1 ? $category : ['category' => $category, 'page' => $page]) }}</loc>
                <lastmod>{{ $category->updated_at->toDateString() }}</lastmod>
            </url>
        @endfor
    @endforeach
    @foreach($posts as $post)
        <url>
            <loc>{{ route('posts.show', $post) }}</loc>
            <lastmod>{{ $post->updated_at->toDateString() }}</lastmod>
        </url>
    @endforeach
    @foreach($products as $product)
        <url>
            <loc>{{ route('products.show', $product) }}</loc>
            <lastmod>{{ $product->updated_at->toDateString() }}</lastmod>
        </url>
    @endforeach
</urlset>
