<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.products.show', $product)])
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.medias.create', ['product_id' => $product->id]) }}" role="button">{{ __('image.attach') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('admin.medias.partials.'.($images->total() ? 'list' : 'empty'))
</div>
