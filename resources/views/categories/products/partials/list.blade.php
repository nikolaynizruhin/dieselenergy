@foreach ($products->chunk(3) as $chunkedProducts)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
        @foreach ($chunkedProducts as $product)
            <div class="col mb-4">
                <div class="card">
                    <img src="{{ asset('storage/'.$product->defaultImage()->path) }}" class="card-img-top" alt="...">
                    <div class="card-body mb-n3">
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-body">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $product->category->name }}</h6>
                        <h5 class="card-title">@usd($product->price)</h5>
                    </div>
                    @if ($product->attributes->isNotEmpty())
                        <div class="card-body bg-light text-muted">
                            @foreach ($product->attributes as $attribute)
                                <div class="row mb-1">
                                    <div class="col letter-spacing text-gray-500 text-uppercase">
                                        <small>{{ $attribute->name }}</small>
                                    </div>
                                    <div class="col text-secondary">
                                        <small>{{ $attribute->pivot->value . $attribute->measure }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-outline-secondary btn-block">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach