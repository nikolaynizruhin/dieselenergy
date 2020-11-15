@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-5 top-0 right-0 height-72 width-48 position-absolute"></div>
        <div class="dots ml-sm-5 mb-4 bottom-0 left-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4">
                <div class="col">
                    @include('layouts.partials.breadcrumb', [
                        'links' => [
                            $product->category->name => route('categories.products.index', $product->category),
                            $product->name => route('products.show', $product)
                        ]
                    ])
                </div>
            </div>
            @if (session('status'))
                <div class="row">
                    <div class="col">
                        @include('layouts.partials.alert')
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 col-md">
                    @include('products.partials.carousel')
                </div>
                <div class="col-12 col-md">
                    <h5 class="font-weight-bold mb-3">
                        {{ $product->name }}
                        <br>
                        <small class="text-muted">{{ $product->category->name }}</small>
                    </h5>
                    <h5 class="text-primary">@uah($product->uah_price)</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aspernatur assumenda consectetur, debitis dicta dolorum earum eius eos inventore libero maxime molestiae nostrum obcaecati odit possimus quo recusandae sed totam.
                    </p>
                    <form class="mb-3" action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-2 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <label for="inputAmount" class="sr-only">Кількість</label>
                                    <input type="number" name="quantity" value="1" min="1" max="99" class="form-control" id="inputAmount" aria-describedby="amountHelp">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Додати в кошик</button>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted">
                        @include('layouts.partials.icon', ['name' => 'shield-check', 'width' => '1.5em', 'height' => '1.5em', 'classes' => 'mr-2'])
                        Гарантія протягом 1 року
                    </p>
                    <p class="text-muted">
                        @include('layouts.partials.icon', ['name' => 'truck', 'width' => '1.5em', 'height' => '1.5em', 'classes' => 'mr-2'])
                        Безкоштовна доставка по Києву та Київській області
                    </p>
                    <p class="text-muted">
                        @include('layouts.partials.icon', ['name' => 'tools', 'width' => '1.5em', 'height' => '1.5em', 'classes' => 'mr-2'])
                        Технічна підтримка протягом 1 року
                    </p>
                    <p class="text-muted">
                        @include('layouts.partials.icon', ['name' => 'credit-card', 'width' => '1.5em', 'height' => '1.5em', 'classes' => 'mr-2'])
                        Готівковий та безготівковий розрахунок
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-10 col-lg-10">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Опис</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Характеристики</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active text-justify pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @markdown($product->description)
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Назва</th>
                                    <th scope="col">Значення</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->attributes as $attribute)
                                        <tr>
                                            <th scope="row">{{ $attribute->field }}</th>
                                            <td>{{ $attribute->pivot->value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partials.services')
@endsection
