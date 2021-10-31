<div class="card-header text-muted bg-white lead">
    {{ __('attribute.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted">#</th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.name'),
                        'field' => 'name',
                        'route' => [
                            'name' => 'admin.categories.show',
                            'parameters' => ['category' => $category],
                        ],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.measure'),
                        'field' => 'measure',
                        'route' => [
                            'name' => 'admin.categories.show',
                            'parameters' => ['category' => $category],
                        ],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    {{ __('common.actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($attributes as $key => $attribute)
                <tr>
                    <th scope="row" class="fw-normal">{{ $attributes->firstItem() + $key }}</th>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->measure }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.specifications.edit', $attribute->pivot->id) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteSpecificationModal'.$attribute->id,
                            'label' => 'deleteSpecificationLabel'.$attribute->id,
                            'title' => __('attribute.delete'),
                            'body' => __('common.alert.detach').' '.$attribute->name.'?',
                            'action' => route('admin.specifications.destroy', $attribute->pivot->id),
                            'button' => __('common.detach'),
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $attributes->total() }} {{ __('common.records') }}
        {{ $attributes->links() }}
    </div>
</div>
