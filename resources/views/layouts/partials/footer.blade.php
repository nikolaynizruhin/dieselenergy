<footer class="bg-dark mt-auto py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/images/logo-white.svg') }}" alt="{{ config('app.name') }}" width="150" class="mb-3" loading="lazy">
                </a>
                <p class="text-gray-400">Надійні рішення для постачання<br>електроенергії</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <span class="d-block text-gray-500 mb-3">ТОВАРИ</span>
                @foreach($categories as $category)
                    <a class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2" href="{{ route('categories.products.index', $category) }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <span class="d-block text-gray-500 mb-3">КОМПАНІЯ</span>
                <a class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2" href="{{ route('home').'#services' }}">
                    Послуги
                </a>
                <a class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2" href="{{ route('posts.index') }}">
                    Блог
                </a>
                <a class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2" href="{{ route('home').'#numbers' }}">
                    Про нас
                </a>
                <a class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2" href="{{ route('privacy') }}">
                    Політики
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <span class="d-block text-gray-500 mb-3">КОНТАКТИ</span>
                <a href="tel:{{ config('company.phone') }}" class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'telephone', 'classes' => 'mr-2', 'width' => '1.3em', 'height' => '1.3em'])
                    +38 (097) 799 75 42
                </a>
                <a href="mailto:{{ config('company.email') }}" class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'mr-2', 'width' => '1.3em', 'height' => '1.3em'])
                    {{ config('company.email') }}
                </a>
                <a href="{{ config('company.facebook') }}" class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2">
                    @include('layouts.partials.icon', ['name' => 'facebook', 'classes' => 'mr-2', 'width' => '1.3em', 'height' => '1.3em'])
                    {{ config('app.name') }}
                </a>
            </div>
        </div>

        <hr class="border-top">

        <div class="row justify-content-center mt-5 mb-3">
            <div class="col text-center text-gray-500">
                &copy; {{ date('Y') }} Diesel Energy, LLC.
            </div>
        </div>
    </div>
</footer>
