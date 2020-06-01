<div class="row">
    <div class="col-md-4">
        @include('layouts.partials.search', ['url' => route('products.show', $product)])
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('medias.create', ['product_id' => $product->id]) }}" role="button">{{ __('Attach Image') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('medias.partials.'.($images->total() ? 'list' : 'empty'))
</div>
