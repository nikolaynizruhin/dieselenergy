<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($product->images as $image)
            <li data-target="#carouselIndicators" data-slide-to="{{ $loop->index }}" @if($image->pivot->is_default) class="active" @endif></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($product->images as $image)
            <div class="carousel-item @if($image->pivot->is_default) active @endif">
                <img src="{{ asset('/storage/'.$image->path) }}" class="d-block w-100" alt="{{ $product->name }}">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
