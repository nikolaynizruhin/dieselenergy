<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.categories.show', $category)])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.specifications.create', ['category_id' => $category->id]) }}" role="button">{{ __('attribute.attach') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @includeWhen($attributes->isNotEmpty(), 'admin.specifications.partials.list')
    @includeWhen($attributes->isEmpty(), 'admin.layouts.partials.empty', [
        'body' => __('attribute.missing'),
        'link' => route('admin.specifications.create', ['category_id' => $category->id]),
        'button' => __('specification.add'),
    ])
</div>
