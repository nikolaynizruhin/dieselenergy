<div class="card-header text-muted lead">
    {{ __('category.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" class="text-muted">#</th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.name'),
                       'field' => 'name',
                       'route' => ['name' => 'admin.categories.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.slug'),
                       'field' => 'slug',
                       'route' => ['name' => 'admin.categories.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($categories as $key => $category)
                <tr>
                    <th scope="row" class="fw-normal">{{ $categories->firstItem() + $key }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.categories.show', $category) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteCategoryModal'.$category->id,
                            'label' => 'deleteCategoryLabel'.$category->id,
                            'title' => __('category.delete'),
                            'body' => __('common.alert.delete').' '.$category->name.'?',
                            'action' => route('admin.categories.destroy', $category),
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $categories->total() }} {{ __('common.records') }}
        {{ $categories->links() }}
    </div>
</div>
