<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">

                        <h3 class="text-center my-5">
                            @include('layouts.partials.icon', ['name' => 'intersect', 'classes' => 'mr-3 text-primary', 'width' => '1.5em', 'height' => '1.5em'])
                            {{ config('app.name') }}
                        </h3>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
