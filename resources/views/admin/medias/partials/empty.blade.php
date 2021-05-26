<div class="card-body text-center text-muted">
    <p class="mb-3">
        @include('layouts.partials.icon', ['name' => 'file-earmark-plus', 'width' => '2.5em', 'height' => '2.5em'])
    </p>
    <p class="mb-3">
        {{ __('image.missing') }}
    </p>
    <a class="btn btn-outline-primary d-block d-md-inline-block" href="{{ route('admin.medias.create', ['product_id' => $product->id]) }}" role="button">
        {{ __('media.add') }}
    </a>
</div>
