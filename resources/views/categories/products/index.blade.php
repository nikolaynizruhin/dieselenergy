@extends('layouts.app')

@section('title', $category->name)

@section('description', $category->name)

@section('keywords', $category->name)

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4">
                <div class="col">
                    @include('layouts.partials.breadcrumb', ['links' => [$category->name => route('categories.products.index', $category)]])
                </div>
                <div class="col text-right text-gray-500">
                    Всього: {{ $products->total() }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                    <form>
                        <p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
                            <small>Пошук</small>
                        </p>

                        <div class="form-group">
                            <label for="inputSearch" class="sr-only">Пошук</label>
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" id="inputSearch" aria-describedby="emailHelp" placeholder="Знайти товар..." autocomplete="search">
                        </div>

                        <p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
                            <small>Сортувати</small>
                        </p>

                        <div class="form-group">
                            <label for="selectSort" class="sr-only">Сортувати</label>
                            <select class="form-control form-control-sm" name="sort" onchange="this.form.submit()" id="selectSort">
                                <option value="name" @if (request('sort') === 'name') selected @endif>Назва (А - Я)</option>
                                <option value="-name" @if (request('sort') === '-name') selected @endif>Назва (Я - А)</option>
                                <option value="price" @if (request('sort') === 'price') selected @endif>Ціна (Низька > Висока)</option>
                                <option value="-price" @if (request('sort') === '-price') selected @endif>Ціна (Висока > Низька)</option>
                            </select>
                        </div>

                        @includeIf('categories.products.partials.filters.'.$category->slug)
                    </form>
                </div>
                <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                    @include('layouts.partials.alert')
                    @include('categories.products.partials.'.($products->isEmpty() ? 'empty' : 'list'))
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col offset-md-3 offset-lg-2">
                    {{ $products->withQueryString()->links('layouts.partials.pagination') }}
                </div>
            </div>
        </div>
    </section>
@endsection
