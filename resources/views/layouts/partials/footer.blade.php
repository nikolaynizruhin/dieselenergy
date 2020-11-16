<footer class="bg-dark mt-auto py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/images/logo-white.svg') }}" alt="{{ config('app.name') }}" width="150" class="mb-3">
                </a>
                <p class="text-gray-400">Надійні рішення для постачання<br>електроенергії</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <span class="d-block text-gray-500 mb-3">ТОВАРИ</span>
                @foreach(\App\Models\Category::all() as $category)
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone mr-2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    +38 (097) 799 75 42
                </a>
                <a href="mailto:{{ config('company.email') }}" class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    {{ config('company.email') }}
                </a>
                <a href="{{ config('company.facebook') }}" class="d-block text-gray-300 hover-text-secondary text-decoration-none mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                    {{ config('app.name') }}
                </a>
            </div>
        </div>

        <hr class="border-top">

        <div class="row justify-content-center mt-5 mb-3">
            <div class="col text-center text-gray-500">
                &copy; 2020 Diesel Energy, Inc. All rights reserved.
            </div>
        </div>
    </div>
</footer>
