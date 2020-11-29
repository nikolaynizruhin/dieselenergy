@foreach ($products->chunk(3) as $chunkedProducts)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
        @foreach ($chunkedProducts as $product)
            <div class="col mb-4">
                <div class="card shadow-sm">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ asset('storage/'.$product->defaultImage()->path) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy">
                    </a>
                    <div class="card-body mb-n3">
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $product) }}" class="text-body">
                                {{ $product->name }}
                            </a>
                        </h6>
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
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-outline-secondary btn-block">
                                @include('layouts.partials.icon', ['name' => 'cart2', 'classes' => 'pb-1', 'width' => '1.4em', 'height' => '1.4em'])
                                Купити
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
