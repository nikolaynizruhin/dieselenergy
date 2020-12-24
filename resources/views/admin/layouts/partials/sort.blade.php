@switch(request('sort'))
    @case($nested ? [$nested => $field] : $field)
        <a href="{{ route($route['name'], array_merge($route['parameters'], ['sort' => $nested ? [$nested => '-'.$field] : '-'.$field])) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-down', 'classes' => 'mt-1', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @case($nested ? [$nested => '-'.$field] : '-'.$field)
        <a href="{{ route($route['name'], $route['parameters']) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-up', 'classes' => 'mb-1', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @default
        <a href="{{ route($route['name'], array_merge($route['parameters'], ['sort' => $nested ? [$nested => $field] : $field])) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-expand', 'width' => '1em', 'height' => '1em'])
        </a>
@endswitch
