<div class="card-body text-center text-muted">
    <p class="mb-3">
        @include('layouts.partials.icon', ['name' => 'file-earmark-plus', 'width' => '2.5em', 'height' => '2.5em'])
    </p>
    <p class="mb-3">
        {{ __('product.missing') }}
    </p>
    @include('admin.products.partials.add', ['classes' => 'btn-outline-primary'])
</div>
