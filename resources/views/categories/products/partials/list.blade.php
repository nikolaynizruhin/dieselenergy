<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    @foreach ($products as $product)
        @include('categories.products.partials.product', ['product' => $product, 'hasAttributes' => true])
    @endforeach
</div>
