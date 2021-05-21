@if ($paginator->hasPages())
    <div class="row">
        <div class="col-2">
            <!-- Previous Page Link -->
            @if ($paginator->onFirstPage())
                <span class="text-gray-500" aria-hidden="true">@lang('pagination.previous')</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="text-gray-500 text-decoration-none" rel="prev" aria-label="@lang('pagination.previous')">@lang('pagination.previous')</a>
            @endif
        </div>
        <div class="col text-center">
            <!-- Pagination Elements -->
            @foreach ($elements as $element)
                <!-- "Three Dots" Separator -->
                @if (is_string($element))
                    <span class="me-4 text-gray-500">{{ $element }}</span>
                @endif

                <!-- Array Of Links -->
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="me-4 text-muted">{{ $page }}</span>
                        @else
                            <a class="text-gray-500 text-decoration-none @if (! $loop->last) me-4 @endif" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
        <div class="col-2 text-end">
            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="text-gray-500 text-decoration-none" rel="next" aria-label="@lang('pagination.next')">@lang('pagination.next')</a>
            @else
                <span aria-hidden="true" class="text-gray-500">@lang('pagination.next')</span>
            @endif
        </div>
    </div>
@endif
