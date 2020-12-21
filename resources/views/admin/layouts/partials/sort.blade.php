@switch(request('sort'))
    @case($field)
        <a href="{{ route($route, ['sort' => '-'.$field]) }}">
            @include('layouts.partials.icon', ['name' => 'chevron-down', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @case('-'.$field)
        <a href="{{ route($route) }}">
            @include('layouts.partials.icon', ['name' => 'chevron-up', 'width' => '0.7em', 'height' => '0.7em'])
        </a>
        @break

    @default
        <a href="{{ route($route, ['sort' => $field]) }}">
            @include('layouts.partials.icon', ['name' => 'chevron-expand', 'width' => '1em', 'height' => '1em'])
        </a>
@endswitch
