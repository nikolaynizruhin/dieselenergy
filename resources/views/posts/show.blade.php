@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-5 top-0 right-0 height-72 width-48 position-absolute"></div>
        <div class="dots ml-sm-5 mb-3 bottom-0 left-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row mt-n3 mb-4">
                <div class="col">
                    @include('layouts.partials.breadcrumb', ['links' => [$post->title => route('posts.index', $post)]])
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>{{ $post->title }}</h3>
                    @markdown($post->body)
                </div>
            </div>
        </div>
    </section>
@endsection
