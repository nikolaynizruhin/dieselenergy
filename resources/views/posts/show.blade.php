@extends('layouts.app')

@section('title', $post->title)

@section('description', $post->title.'. Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('keywords', $post->title)

@section('content')
    <section class="pt-4 pb-5">

        <div class="container position-relative">
            <div class="dots top-0 end-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>

            <div class="row justify-content-center mb-4">
                <div class="col col-md-8 col-lg-6">
                    @include('layouts.partials.breadcrumb', ['links' => ['Блог' => route('posts.index'), $post->title => route('posts.show', $post)]])
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col col-md-8 col-lg-6">
                    <h1 class="h2 mb-3">{{ $post->title }}</h1>
                    <img src="{{ asset('/storage/'.$post->image->path) }}" class="img-fluid rounded mb-3" alt="{{ $post->title }}" loading="lazy">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col col-md-8 col-lg-6 text-justify lh-lg">
                    @markdown($post->body)
                </div>
            </div>

            <div class="dots bottom-0 start-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>
        </div>
    </section>
@endsection
