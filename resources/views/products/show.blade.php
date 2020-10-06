@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-5 top-0 right-0 height-72 width-48 position-absolute"></div>
        <div class="dots ml-sm-5 mb-4 bottom-0 left-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4 text-gray-500">
                <div class="col letter-spacing d-flex align-items-center">
                    Магазин
                    @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                    {{ $product->category->name }}
                    @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
                    {{ $product->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md">
                    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach($product->images as $image)
                                <div class="carousel-item active">
                                    <img src="{{ asset('/storage/'.$image->path) }}" class="d-block w-100" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md">
                    <h5 class="font-weight-bold mb-3">
                        {{ $product->name }}
                        <br>
                        <small class="text-muted">{{ $product->category->name }}</small>
                    </h5>
                    <h5 class="text-primary">@usd($product->price)</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aspernatur assumenda consectetur, debitis dicta dolorum earum eius eos inventore libero maxime molestiae nostrum obcaecati odit possimus quo recusandae sed totam.
                    </p>
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-2 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <label for="inputAmount" class="sr-only">Amount</label>
                                    <input type="number" name="quantity" value="1" min="1" max="99" class="form-control" id="inputAmount" aria-describedby="amountHelp">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Опис</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Характеристики</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br>
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
@endsection
