@extends('layouts.app')

@section('title', $product->name)

@section('description', $product->name.'. '.$product->category->name.'. Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('keywords', implode(',', [$product->name, $product->brand->name.' '.$product->model, $product->category->name]))

@section('content')
    <section class="pt-4 pb-5">

        <div class="container position-relative">
            <div class="dots top-0 end-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>

            <div class="row mb-4">
                <div class="col">
                    @include('layouts.partials.breadcrumb', [
                        'links' => [
                            $product->category->name => route('categories.products.index', $product->category),
                            $product->name => route('products.show', $product)
                        ]
                    ])
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12 col-md px-xl-5">
                    @include('products.partials.carousel')
                </div>
                <div class="col-12 col-md">
                    <h1 class="fw-bold mb-3 h4">
                        {{ $product->name }}
                        <br>
                        <small class="text-muted">{{ $product->category->name }}</small>
                    </h1>
                    <p class="text-muted mb-0">Виробник:</p>
                    <p class="text-body fw-bold">{{ $product->brand->name }}</p>
                    <p class="text-muted mb-0">Модель:</p>
                    <p class="text-body fw-bold">{{ $product->model }}</p>
                    <p class="text-primary mb-3 h4">{{ $product->price->toUAH()->format() }}</p>
                    <form class="mb-3" action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-3 col-sm-2 col-md-3 col-lg-2">
                                <div class="mb-3">
                                    <label for="inputAmount" class="visually-hidden">Кількість</label>
                                    <input type="number" name="quantity" value="1" min="1" max="99" class="form-control" id="inputAmount" aria-describedby="amountHelp">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary text-white">
                                    @include('layouts.partials.icon', ['name' => 'cart2', 'classes' => 'pb-1', 'width' => '1.4em', 'height' => '1.4em'])
                                    Купити
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-borderless text-muted">
                        <tbody>
                        <tr>
                            <td>@include('layouts.partials.icon', ['name' => 'shield-check', 'width' => '1.5em', 'height' => '1.5em'])</td>
                            <td>Гарантійне та післягарантійне обслуговування електростанцій</td>
                        </tr>
                        <tr>
                            <td>@include('layouts.partials.icon', ['name' => 'truck', 'width' => '1.5em', 'height' => '1.5em'])</td>
                            <td>Доставка продукції здійснюється по всій Україні</td>
                        </tr>
                        <tr>
                            <td>@include('layouts.partials.icon', ['name' => 'tools', 'width' => '1.5em', 'height' => '1.5em'])</td>
                            <td>Cервісне технічне обслуговування нашими спеціалістами</td>
                        </tr>
                        <tr>
                            <td>@include('layouts.partials.icon', ['name' => 'credit-card', 'width' => '1.5em', 'height' => '1.5em'])</td>
                            <td>Безготівковий розрахунок</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-10 col-lg-9">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Опис</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="attribute-tab" data-bs-toggle="tab" data-bs-target="#attribute" type="button" role="tab" aria-controls="attribute" aria-selected="false">Характеристики</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active text-justify pt-4" id="description" role="tabpanel" aria-labelledby="description-tab">
                            @markdown($product->description)
                        </div>
                        <div class="tab-pane fade pt-2" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                            <table class="table">
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

            <div class="dots bottom-0 start-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>
        </div>
    </section>

    @include('products.partials.recommendations')

    @include('layouts.partials.services')
@endsection
