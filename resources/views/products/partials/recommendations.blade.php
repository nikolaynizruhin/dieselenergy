<section>
    <div class="container">
        <h4 class="mb-3">Також вас можуть зацікавити</h4>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @foreach ($product->recommendations() as $recommendation)
                @include('categories.products.partials.product', ['product' => $recommendation, 'hasAttributes' => false])
            @endforeach
        </div>
    </div>
</section>
