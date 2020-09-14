<div class="card-body d-flex flex-column align-items-center text-muted">
    @include('layouts.partials.icon', ['name' => 'file-plus', 'classes' => 'mb-3', 'width' => '2.5em', 'height' => '2.5em'])
    {{ __('product.missing') }}
    @include('admin.products.partials.add', ['classes' => 'btn-outline-primary mt-3'])
</div>
