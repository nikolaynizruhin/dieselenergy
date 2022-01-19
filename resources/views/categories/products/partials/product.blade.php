<div class="col mb-4">
    <div class="card h-100 shadow-sm">
        <img src="{{ asset('storage/'.$product->images->first()->path) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy">
        <div class="card-body mb-n3">
            <h3 class="card-title h6">{{ $product->name }}</h3>
            <p class="card-subtitle mb-2 text-muted">{{ $product->category->name }}</p>
            <p class="card-title text-primary h5">{{ $product->price->toUAH()->format() }}</p>
        </div>
        @if ($hasAttributes && $product->attributes->isNotEmpty())
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
            <div class="d-grid">
                <a href="{{ route('products.show', $product) }}" role="button" class="btn btn-outline-secondary stretched-link">
                    Деталі
                </a>
            </div>
        </div>
    </div>
</div>
