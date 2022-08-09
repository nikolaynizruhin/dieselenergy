<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/sass/admin/admin.scss', 'resources/js/admin/admin.js'])
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
</body>
</html>
