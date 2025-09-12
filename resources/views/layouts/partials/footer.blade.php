<footer class="bg-dark mt-auto py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/images/logo-white.svg') }}" alt="{{ config('app.name') }}" width="150" height="39" class="mb-3" loading="lazy">
                </a>
                <p class="text-gray-300">Надійні рішення для постачання<br>електроенергії</p>
            </div>
{{--            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">--}}
{{--                <strong class="d-block text-gray-500 mb-2 letter-spacing">ТОВАРИ</strong>--}}
{{--                @foreach($categories as $category)--}}
{{--                    <a class="d-block text-gray-300 text-decoration-none mb-2" href="{{ route('categories.products.index', $category) }}">--}}
{{--                        {{ $category->name }}--}}
{{--                    </a>--}}
{{--                @endforeach--}}
{{--            </div>--}}
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <strong class="d-block text-gray-500 mb-2 letter-spacing">КОМПАНІЯ</strong>
                <a class="d-block text-gray-300 text-decoration-none mb-2" href="{{ route('home').'#services' }}">
                    Послуги
                </a>
                <a class="d-block text-gray-300 text-decoration-none mb-2" href="{{ route('home').'#about-us' }}">
                    Про нас
                </a>
{{--                <a class="d-block text-gray-300 text-decoration-none mb-2" href="{{ route('posts.index') }}">--}}
{{--                    Блог--}}
{{--                </a>--}}
                <a class="d-block text-gray-300 text-decoration-none mb-2" href="{{ route('privacy') }}">
                    Політика конфіденційності
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <strong class="d-block text-gray-500 mb-2 letter-spacing">КОНТАКТИ</strong>
                <a href="tel:{{ config('company.phone') }}" class="d-block icon-link  text-gray-300 text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'telephone', 'classes' => 'me-2', 'width' => '1.3em', 'height' => '1.3em'])
                    +38 (097) 799 75 42
                </a>
                <a href="mailto:{{ config('company.email') }}" class="d-block icon-link text-gray-300 text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'me-2', 'width' => '1.3em', 'height' => '1.3em'])
                    {{ config('company.email') }}
                </a>
                <a href="{{ config('company.facebook') }}" class="d-block icon-link  text-gray-300 text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'facebook', 'classes' => 'me-2', 'width' => '1.3em', 'height' => '1.3em'])
                    {{ config('app.name') }}
                </a>
            </div>
        </div>

        <hr class="border-top">

        <div class="row justify-content-center mt-5 mb-3">
            <div class="col text-center text-gray-300">
                &copy; {{ date('Y') }} {{ config('app.name') }}, LLC.
            </div>
        </div>
    </div>
</footer>
