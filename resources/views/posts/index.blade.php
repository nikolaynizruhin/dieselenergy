@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots ml-sm-5 mt-5 top-0 left-0 height-72 width-48 position-absolute"></div>
        <div class="dots mr-sm-5 mb-3 bottom-0 right-0 height-72 width-48 position-absolute"></div>

        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-center flex-column mb-5">
                    <div class="text-center">
                        <h2>From The Blog</h2>
                        <h5 class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
                    </div>
                </div>
            </div>
            @include('posts.partials.'.($posts->isEmpty() ? 'empty' : 'list'))
        </div>
    </section>
@endsection
