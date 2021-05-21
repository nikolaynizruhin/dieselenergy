@extends('layouts.app')

@section('title', 'Блог')

@section('description', 'Статті про джерела безперебійного живлення. Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('content')
    <section class="py-5">
        <div class="container position-relative">
            <div class="dots top-0 start-0 height-72 width-48 position-absolute z-n1"></div>

            <div class="row">
                <div class="col d-flex justify-content-center flex-column mb-5">
                    <div class="text-center">
                        <h1 class="h2">Блог</h1>
                        <h2 class="h5 text-muted">Добірка цікавої інформації та новин</h2>
                    </div>
                </div>
            </div>

            @include('posts.partials.'.($posts->isEmpty() ? 'empty' : 'list'))

            <div class="dots bottom-0 end-0 height-72 width-48 position-absolute z-n1"></div>
        </div>
    </section>
@endsection
