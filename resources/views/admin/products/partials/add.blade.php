<div class="dropdown">
    <button class="btn dropdown-toggle {{ $classes }}" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('product.add') }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        @forelse($categories as $category)
            <li>
                <a class="dropdown-item" href="{{ route('admin.products.create', ['category_id' => $category->id]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @empty
            <li class="px-3">{{ __('category.empty') }}</li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('admin.categories.create') }}">
                    {{ __('category.add') }}
                </a>
            </li>
        @endforelse
    </ul>
</div>
