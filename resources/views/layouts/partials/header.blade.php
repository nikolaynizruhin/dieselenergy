<nav class="navbar navbar-expand-md navbar-light bg-white py-3">
    <div class="container-lg">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" width="130">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Товари
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item" href="{{ route('categories.products.index', $category) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#services' }}">Послуги</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#about-us' }}">Про нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">Блог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#contact' }}">Контакти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('carts.index') }}">
                        Кошик
                        @if(\Facades\App\Cart\Cart::items()->isNotEmpty())
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-dot text-primary position-absolute top-0 ml-n2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            </svg>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
