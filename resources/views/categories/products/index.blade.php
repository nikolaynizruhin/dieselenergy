@extends('layouts.app')

@section('title', $category->name)

@section('description', $category->name.'. Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('keywords', $category->name)

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4">
                <div class="col">
                    @include('layouts.partials.breadcrumb', ['links' => [$category->name => route('categories.products.index', $category)]])
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <h1 class="h4">{{ $category->name }}</h1>
                </div>
                <div class="col text-right text-gray-500">
                    Всього: {{ $products->total() }}
                </div>
            </div>
            <div class="row">
                <div class="col d-sm-none">
                    <button class="btn btn-outline-secondary btn-block mb-3" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                        @include('layouts.partials.icon', ['name' => 'funnel', 'classes' => 'pb-1', 'width' => '1.4em', 'height' => '1.4em'])
                        Фільтри
                    </button>
                    <div class="collapse mb-3" id="collapseFilters">
                        <div class="card card-body">
                            @include('categories.products.partials.filters')
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-block col-sm-4 col-md-3 col-lg-2">
                    @include('categories.products.partials.filters')
                </div>
                <div class="col-12 col-sm-8 col-md-9 col-lg-10">
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
