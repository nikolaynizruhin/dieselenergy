<nav class="text-gray-500" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb align-items-center">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-gray-500">@include('layouts.partials.icon', ['name' => 'house-door-fill', 'width' => '1.2em', 'height' => '1.2em'])</a>
        </li>
        @foreach($links as $name => $link)
            @include('layouts.partials.icon', ['name' => 'chevron-right', 'classes' => 'mx-2', 'width' => '0.9em', 'height' => '0.9em'])
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $link }}" class="text-gray-500 text-decoration-none">{{ $name }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
