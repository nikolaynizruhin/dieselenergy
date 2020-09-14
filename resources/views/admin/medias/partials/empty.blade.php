<div class="card-body d-flex flex-column align-items-center text-muted">
    @include('layouts.partials.icon', ['name' => 'file-plus', 'classes' => 'mb-3', 'width' => '2.5em', 'height' => '2.5em'])
    {{ __('image.missing') }}
    <a class="btn btn-outline-primary d-block d-md-inline-block mt-3" href="{{ route('admin.medias.create', ['product_id' => $product->id]) }}" role="button">
        {{ __('media.add') }}
    </a>
</div>
