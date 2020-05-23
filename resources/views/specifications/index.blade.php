<div class="row">
    <div class="col-md-4">
        @include('layouts.partials.search', ['url' => route('categories.show', $category)])
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('specifications.create', ['category_id' => $category->id]) }}" role="button">{{ __('Attach Attribute') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('specifications.partials.'.($attributes->total() ? 'list' : 'empty'))
</div>
