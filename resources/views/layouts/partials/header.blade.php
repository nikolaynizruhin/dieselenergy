<nav class="navbar navbar-expand-md bg-white py-3">
    <div class="container-lg">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" width="130" height="34">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown d-none d-md-flex">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Товари
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item" href="{{ route('categories.products.index', $category) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>
                @foreach($categories as $category)
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="{{ route('categories.products.index', $category) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#services' }}">Послуги</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#about-us' }}">Про нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('posts.*')) active @endif" @if (request()->routeIs('posts.*')) aria-current="page" @endif href="{{ route('posts.index') }}">Блог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#contact' }}">Контакти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('carts.*')) active @endif position-relative" @if (request()->routeIs('posts.*')) aria-current="page" @endif href="{{ route('carts.index') }}">
                        @include('layouts.partials.icon', ['name' => 'cart2', 'classes' => 'pb-1', 'width' => '1.4em', 'height' => '1.4em'])
                        @if(\Facades\App\Services\Cart::items()->isNotEmpty())
                            @include('layouts.partials.icon', ['name' => 'dot', 'classes' => 'text-primary position-absolute top-0 ms-n2', 'width' => '1.5em', 'height' => '1.5em'])
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
