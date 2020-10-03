<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container-lg">
        <a class="navbar-brand d-flex" href="{{ route('home') }}">
            @include('layouts.partials.icon', ['name' => 'intersect', 'classes' => 'mr-3 text-primary', 'width' => '1.5em', 'height' => '1.5em'])
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Shop
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach(\App\Models\Category::all() as $category)
                            <a class="dropdown-item" href="{{ route('categories.products.index', $category) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#services' }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#contact' }}">Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#numbers' }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home').'#faq' }}">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carts.index') }}">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
