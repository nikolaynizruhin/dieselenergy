<ul class="nav flex-column d-none d-md-flex">
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin')) text-dark @endif d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            @include('layouts.partials.icon', ['name' => 'pie-chart', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('dashboard.title') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/products')) text-dark @endif d-flex align-items-center" href="{{ route('admin.products.index') }}">
            @include('layouts.partials.icon', ['name' => 'tag', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('product.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/orders')) text-dark @endif d-flex align-items-center" href="{{ route('admin.orders.index') }}">
            @include('layouts.partials.icon', ['name' => 'bucket', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('order.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/customers')) text-dark @endif d-flex align-items-center" href="{{ route('admin.customers.index') }}">
            @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('customer.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/categories')) text-dark @endif d-flex align-items-center" href="{{ route('admin.categories.index') }}">
            @include('layouts.partials.icon', ['name' => 'list-task', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('category.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/brands')) text-dark @endif d-flex align-items-center" href="{{ route('admin.brands.index') }}">
            @include('layouts.partials.icon', ['name' => 'briefcase', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('brand.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/attributes')) text-dark @endif d-flex align-items-center" href="{{ route('admin.attributes.index') }}">
            @include('layouts.partials.icon', ['name' => 'puzzle', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('attribute.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/images')) text-dark @endif d-flex align-items-center" href="{{ route('admin.images.index') }}">
            @include('layouts.partials.icon', ['name' => 'image', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('common.images') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/users')) text-dark @endif d-flex align-items-center" href="{{ route('admin.users.index') }}">
            @include('layouts.partials.icon', ['name' => 'person-check', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('user.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/contacts')) text-dark @endif d-flex align-items-center" href="{{ route('admin.contacts.index') }}">
            @include('layouts.partials.icon', ['name' => 'envelope', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('contact.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/posts')) text-dark @endif d-flex align-items-center" href="{{ route('admin.posts.index') }}">
            @include('layouts.partials.icon', ['name' => 'file-text', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('post.plural') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('admin/currencies')) text-dark @endif d-flex align-items-center" href="{{ route('admin.currencies.index') }}">
            @include('layouts.partials.icon', ['name' => 'cash-stack', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
            {{ __('currency.plural') }}
        </a>
    </li>
</ul>
