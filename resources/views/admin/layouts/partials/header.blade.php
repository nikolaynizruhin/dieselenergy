<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-lg">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">
            @include('layouts.partials.icon', ['name' => 'intersect', 'classes' => 'mr-3 text-primary', 'width' => '1.5em', 'height' => '1.5em'])
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto d-md-none">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        @include('layouts.partials.icon', ['name' => 'pie-chart', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('dashboard.title') }} <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}">
                        @include('layouts.partials.icon', ['name' => 'tag', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('product.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        @include('layouts.partials.icon', ['name' => 'bucket', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('order.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customers.index') }}">
                        @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('customer.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
                        @include('layouts.partials.icon', ['name' => 'list-task', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('category.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.brands.index') }}">
                        @include('layouts.partials.icon', ['name' => 'briefcase', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('brand.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.attributes.index') }}">
                        @include('layouts.partials.icon', ['name' => 'puzzle', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('attribute.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.images.index') }}">
                        @include('layouts.partials.icon', ['name' => 'image', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('common.images') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        @include('layouts.partials.icon', ['name' => 'person-check', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('user.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                        @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('contact.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.posts.index') }}">
                        @include('layouts.partials.icon', ['name' => 'file-text', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('post.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.currencies.index') }}">
                        @include('layouts.partials.icon', ['name' => 'cash-stack', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                        {{ __('currency.plural') }}
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">{{ __('auth.login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.users.edit', Auth::user()) }}">
                                @include('layouts.partials.icon', ['name' => 'gear', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                                {{ __('common.settings') }}
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                @include('layouts.partials.icon', ['name' => 'box-arrow-right', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
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
