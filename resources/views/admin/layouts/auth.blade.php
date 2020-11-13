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
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">

                    <div class="text-center my-5">
                        <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" width="200">
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
