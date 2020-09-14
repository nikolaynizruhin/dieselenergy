<div class="dropdown">
    <button class="btn dropdown-toggle {{ $classes }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('product.add') }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @forelse($categories as $category)
            <a class="dropdown-item" href="{{ route('admin.products.create', ['category_id' => $category->id]) }}">
                @include('layouts.partials.icon', ['name' => 'plus', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                {{ $category->name }}
            </a>
        @empty
            <span class="dropdown-item-text">{{ __('category.empty') }}</span>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('admin.categories.create') }}">
                @include('layouts.partials.icon', ['name' => 'plus', 'classes' => 'mr-2', 'width' => '1.1em', 'height' => '1.1em'])
                {{ __('category.title') }}
            </a>
        @endforelse
    </div>
</div>
