<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.products.show', $product)])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.medias.create', ['product_id' => $product->id]) }}" role="button">{{ __('image.attach') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @includeWhen($images->isNotEmpty(), 'admin.medias.partials.list')
    @includeWhen($images->isEmpty(), 'admin.layouts.partials.empty', [
        'body' => __('image.missing'),
        'link' => route('admin.medias.create', ['product_id' => $product->id]),
        'button' => __('media.add'),
    ])
</div>
