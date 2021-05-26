<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-lg">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" width="130">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto d-md-none">
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.dashboard')) active @endif" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif href="{{ route('admin.dashboard') }}">
                        @include('layouts.partials.icon', ['name' => 'pie-chart', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('dashboard.title') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.products.*')) active @endif" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif href="{{ route('admin.products.index') }}">
                        @include('layouts.partials.icon', ['name' => 'tag', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('product.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.orders.*')) active @endif" @if (request()->routeIs('admin.orders.*')) aria-current="page" @endif href="{{ route('admin.orders.index') }}">
                        @include('layouts.partials.icon', ['name' => 'bucket', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('order.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.customers.*')) active @endif" @if (request()->routeIs('admin.customers.*')) aria-current="page" @endif href="{{ route('admin.customers.index') }}">
                        @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('customer.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.categories.*')) active @endif" @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif href="{{ route('admin.categories.index') }}">
                        @include('layouts.partials.icon', ['name' => 'list-task', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('category.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.brands.*')) active @endif" @if (request()->routeIs('admin.brands.*')) aria-current="page" @endif href="{{ route('admin.brands.index') }}">
                        @include('layouts.partials.icon', ['name' => 'briefcase', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('brand.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.attributes.*')) active @endif" @if (request()->routeIs('admin.attributes.*')) aria-current="page" @endif href="{{ route('admin.attributes.index') }}">
                        @include('layouts.partials.icon', ['name' => 'puzzle', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('attribute.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.images.*')) active @endif" @if (request()->routeIs('admin.images.*')) aria-current="page" @endif href="{{ route('admin.images.index') }}">
                        @include('layouts.partials.icon', ['name' => 'image', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('common.images') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.users.*')) active @endif" @if (request()->routeIs('admin.users.*')) aria-current="page" @endif href="{{ route('admin.users.index') }}">
                        @include('layouts.partials.icon', ['name' => 'person-check', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('user.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.contacts.*')) active @endif" @if (request()->routeIs('admin.contacts.*')) aria-current="page" @endif href="{{ route('admin.contacts.index') }}">
                        @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('contact.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.posts.*')) active @endif" @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif href="{{ route('admin.posts.index') }}">
                        @include('layouts.partials.icon', ['name' => 'file-text', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('post.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('admin.currencies.*')) active @endif" @if (request()->routeIs('admin.currencies.*')) aria-current="page" @endif href="{{ route('admin.currencies.index') }}">
                        @include('layouts.partials.icon', ['name' => 'cash-stack', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('currency.plural') }}
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">{{ __('auth.login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.users.edit', Auth::user()) }}">
                                @include('layouts.partials.icon', ['name' => 'gear', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                                {{ __('common.settings') }}
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                @include('layouts.partials.icon', ['name' => 'box-arrow-right', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
                                {{ __('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
