<div class="d-flex align-items-center letter-spacing text-gray-500">
    @foreach($links as $name => $link)
        <a href="{{ $link }}" class="text-gray-500">{{ $name }}</a>
        @if (! $loop->last)
            @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
        @endif
    @endforeach
</div>
