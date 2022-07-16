<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/sass/admin/admin.scss', 'resources/js/app.js'])
</head>
<body>
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-sm-9 col-md-7 col-lg-5 col-xl-4">

                    <div class="text-center my-5">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" width="200">
                        </a>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
