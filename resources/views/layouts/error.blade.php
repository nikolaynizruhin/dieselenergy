@extends('layouts.app')

@section('content')
    <section class="position-relative py-5">
        <div class="dots mr-sm-5 mt-6 top-0 right-0 height-72 width-48 position-absolute"></div>
        <div class="dots ml-sm-5 mt-6 top-0 left-0 height-72 width-48 position-absolute d-none d-md-block"></div>

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="text-center my-6">
                        @include('layouts.partials.icon', ['name' => 'wrench', 'classes' => 'mb-3', 'width' => '5em', 'height' => '5em'])
                        <h4 class="mt-3 letter-spacing">@yield('code') - @yield('message')</h4>
                        <p class="text-muted">Перейти на <a href="{{ route('home') }}" class="text-primary">головну сторінку</a></p>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
