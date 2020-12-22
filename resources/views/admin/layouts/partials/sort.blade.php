@switch(request('sort'))
    @case($field)
        <a href="{{ route($route, ['sort' => '-'.$field]) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-down', 'classes' => 'mt-1', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @case('-'.$field)
        <a href="{{ route($route) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-up', 'classes' => 'mb-1', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @default
        <a href="{{ route($route, ['sort' => $field]) }}" class="text-decoration-none">
            {{ $title }}
            @include('layouts.partials.icon', ['name' => 'chevron-expand', 'width' => '1em', 'height' => '1em'])
        </a>
@endswitch
