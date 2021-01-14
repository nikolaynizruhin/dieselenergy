<section>
    <div class="container">
        <h4 class="mb-3">Також вас можуть зацікавити</h4>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @foreach ($recommendations as $recommendation)
                <div class="col mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/'.$recommendation->images->first()->path) }}" class="card-img-top" alt="{{ $recommendation->name }}" loading="lazy">
                        <div class="card-body mb-n3">
                            <h3 class="card-title h6">{{ $recommendation->name }}</h3>
                            <p class="card-subtitle mb-2 text-muted">{{ $recommendation->category->name }}</p>
                            <p class="card-title text-primary h5">@uah($recommendation->uah_price)</p>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('products.show', $recommendation) }}" role="button" class="btn btn-outline-secondary btn-block stretched-link">
                                Деталі
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
