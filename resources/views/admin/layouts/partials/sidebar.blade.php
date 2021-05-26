<ul class="nav flex-column d-none d-md-flex">
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.dashboard')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif href="{{ route('admin.dashboard') }}">
            @include('layouts.partials.icon', ['name' => 'pie-chart', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('dashboard.title') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.products.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif href="{{ route('admin.products.index') }}">
            @include('layouts.partials.icon', ['name' => 'tag', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('product.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.orders.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.orders.*')) aria-current="page" @endif href="{{ route('admin.orders.index') }}">
            @include('layouts.partials.icon', ['name' => 'bucket', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('order.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.customers.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.customers.*')) aria-current="page" @endif href="{{ route('admin.customers.index') }}">
            @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('customer.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.categories.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif href="{{ route('admin.categories.index') }}">
            @include('layouts.partials.icon', ['name' => 'list-task', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('category.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.brands.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.brands.*')) aria-current="page" @endif href="{{ route('admin.brands.index') }}">
            @include('layouts.partials.icon', ['name' => 'briefcase', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('brand.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.attributes.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.attributes.*')) aria-current="page" @endif href="{{ route('admin.attributes.index') }}">
            @include('layouts.partials.icon', ['name' => 'puzzle', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('attribute.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.images.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.images.*')) aria-current="page" @endif href="{{ route('admin.images.index') }}">
            @include('layouts.partials.icon', ['name' => 'image', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('common.images') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.users.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.users.*')) aria-current="page" @endif href="{{ route('admin.users.index') }}">
            @include('layouts.partials.icon', ['name' => 'person-check', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('user.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.contacts.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.contacts.*')) aria-current="page" @endif href="{{ route('admin.contacts.index') }}">
            @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('contact.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.posts.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif href="{{ route('admin.posts.index') }}">
            @include('layouts.partials.icon', ['name' => 'file-text', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('post.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('admin.currencies.*')) active text-dark @endif d-flex align-items-center" @if (request()->routeIs('admin.currencies.*')) aria-current="page" @endif href="{{ route('admin.currencies.index') }}">
            @include('layouts.partials.icon', ['name' => 'cash-stack', 'classes' => 'me-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('currency.plural') }}
        </a>
    </li>
</ul>
