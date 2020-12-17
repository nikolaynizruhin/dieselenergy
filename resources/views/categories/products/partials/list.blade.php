<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    @foreach ($products as $product)
        <div class="col mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/'.$product->defaultImage()->path) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy">
                <div class="card-body mb-n3">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->category->name }}</h6>
                    <h5 class="card-title text-primary">@uah($product->uah_price)</h5>
                </div>
                @if ($product->attributes->isNotEmpty())
                    <div class="card-body bg-light text-muted">
                        <table class="table table-borderless m-0">
                            <tbody>
                                @foreach ($product->attributes as $attribute)
                                    <tr>
                                        <td class="p-1 letter-spacing text-gray-500 text-uppercase">
                                            <small>{{ $attribute->name }}</small>
                                        </td>
                                        <td class="p-1 text-secondary">
                                            <small>{{ $attribute->pivot->value }} {{ $attribute->measure }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-body">
                    <a href="{{ route('products.show', $product) }}" role="button" class="btn btn-outline-secondary btn-block stretched-link">
                        Деталі
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
