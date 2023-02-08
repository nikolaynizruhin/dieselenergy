@extends('layouts.app')

@section('content')
    <section class="py-5">

        <div class="container position-relative">
            <div class="dots top-0 end-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>

            <div class="row">
                <div class="col">
                    <div class="text-center my-6">
                        @include('layouts.partials.icon', ['name' => 'wrench', 'classes' => 'mb-3', 'width' => '5em', 'height' => '5em'])
                        <h4 class="mt-3 letter-spacing">@yield('code') - @yield('message')</h4>
                        <p class="text-muted">Перейти на <a href="{{ route('home') }}" class="text-primary">головну сторінку</a></p>
                    </div>
                </div>
            </div>

            <div class="dots top-0 start-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>
        </div>
    </section>
@endsection
