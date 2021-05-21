<div class="letter-spacing text-gray-500">
    <a href="{{ route('home') }}" class="text-gray-500 text-decoration-none">
        @include('layouts.partials.icon', ['name' => 'house-door-fill', 'width' => '1.2em', 'height' => '1.2em'])
    </a>
    @foreach($links as $name => $link)
        @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
        @if ($loop->last)
            <span class="text-gray-500">{{ $name }}</span>
        @else
            <a href="{{ $link }}" class="text-gray-500 text-decoration-none">{{ $name }}</a>
        @endif
    @endforeach
</div>
