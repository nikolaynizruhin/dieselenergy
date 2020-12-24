<div class="card-header text-muted bg-white lead">
    {{ __('category.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.name'),
                       'field' => 'name',
                       'route' => ['name' => 'admin.categories.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.slug'),
                       'field' => 'slug',
                       'route' => ['name' => 'admin.categories.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($categories as $key => $category)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $categories->firstItem() + $key }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.categories.show', $category) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteCategoryModal{{ $category->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.categories.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $categories->total() }} {{ __('common.records') }}
        {{ $categories->withQueryString()->links() }}
    </div>
</div>
