<div class="row">
    <div class="col-md-4">
        <form action="{{ route('categories.show', $category) }}" method="GET">
            <div class="form-group">
                <label for="search" class="sr-only">{{ __('Search') }}</label>
                <input type="text" name="search" class="form-control shadow-sm border-0" value="{{ request('search') }}" id="search" aria-describedby="search" placeholder="Search">
            </div>
        </form>
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('specifications.create', ['category_id' => $category->id]) }}" role="button">{{ __('Attach Attribute') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('specifications.partials.'.($attributes->total() ? 'list' : 'empty'))
</div>
