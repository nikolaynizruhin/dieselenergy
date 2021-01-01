@extends('layouts.app')

@section('title', $post->title)

@section('description', $post->title.'. Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('keywords', $post->title)

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-5 top-0 right-0 height-72 width-48 position-absolute"></div>
        <div class="dots ml-sm-5 mb-3 bottom-0 left-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row justify-content-center mt-n3 mb-4">
                <div class="col col-md-10 col-lg-8">
                    @include('layouts.partials.breadcrumb', ['links' => ['Блог' => route('posts.index'), $post->title => route('posts.index', $post)]])
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-10 col-lg-8">
                    <h2 class="mb-3">{{ $post->title }}</h2>
                    <img src="{{ asset('/storage/'.$post->image->path) }}" class="img-fluid rounded mb-3" alt="{{ $post->title }}" loading="lazy">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-10 col-lg-8 text-justify">
                    @markdown($post->body)
                </div>
            </div>
        </div>
    </section>
@endsection
