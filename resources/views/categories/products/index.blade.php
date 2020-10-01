@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mt-n3 mb-4 text-gray-500">
            <div class="col letter-spacing d-flex align-items-center">
                Магазин
                @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                {{ $category->name }}
            </div>
            <div class="col text-right">
                Всього: {{ $products->total() }}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2">
                <form>
                    <p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
                        <small>Пошук</small>
                    </p>

                    <div class="form-group">
                        <label for="inputSearch" class="sr-only">Пошук</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" id="inputSearch" aria-describedby="emailHelp" placeholder="Введіть...">
                    </div>

                    <p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
                        <small>Сортувати</small>
                    </p>

                    <div class="form-group">
                        <label for="selectSort" class="sr-only">Sort</label>
                        <select class="form-control form-control-sm" name="sort" id="selectSort">
                            <option value="name" @if (request('sort') === 'name') selected @endif>Назва (А - Я)</option>
                            <option value="-name" @if (request('sort') === '-name') selected @endif>Назва (Я - А)</option>
                        </select>
                    </div>

                    @includeIf('categories.products.partials.filters.'.$category->slug)

                    <button type="submit" class="btn mt-3 btn-outline-primary btn-block">
                        Filter
                    </button>
                </form>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
                @forelse ($products->chunk(3) as $chunkedProducts)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                        @foreach ($chunkedProducts as $product)
                            <div class="col mb-4">
                                <div class="card">
                                    <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
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
                @empty
                    <p>No products matched the given criteria.</p>
                @endforelse
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col offset-md-3 offset-lg-2">
                {{ $products->withQueryString()->links('layouts.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
