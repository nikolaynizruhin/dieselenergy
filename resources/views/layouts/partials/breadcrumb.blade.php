<div class="d-flex align-items-center letter-spacing text-gray-500">
    <a href="{{ route('home') }}" class="text-gray-500">
        @include('layouts.partials.icon', ['name' => 'house-door-fill', 'width' => '1.2em', 'height' => '1.2em'])
    </a>
    @foreach($links as $name => $link)
        @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-3', 'width' => '0.9em', 'height' => '0.9em'])
        <a href="{{ $link }}" class="text-gray-500">{{ $name }}</a>
    @endforeach
</div>