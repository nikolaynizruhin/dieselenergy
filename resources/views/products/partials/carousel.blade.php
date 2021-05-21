<div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach($product->images as $image)
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="{{ $loop->index }}" @if($image->pivot->is_default) class="active" aria-current="true" @endif aria-label="Slide {{ $loop->index }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($product->images as $image)
            <div class="carousel-item @if($image->pivot->is_default) active @endif">
                <img src="{{ asset('/storage/'.$image->path) }}" class="d-block w-100" alt="{{ $product->name }}">
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">@lang('pagination.previous')</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">@lang('pagination.next')</span>
    </button>
</div>
