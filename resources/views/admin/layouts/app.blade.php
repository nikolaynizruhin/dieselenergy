<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    @include('admin.layouts.partials.header')

    <main class="py-4">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-2">
                    @include('admin.layouts.partials.sidebar')
                </div>
                <div class="col-md-10">
                    @include('admin.layouts.partials.alert')

                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
