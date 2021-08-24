<div class="card-header text-muted bg-white lead">
    {{ __('attribute.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-bottom">#</th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.name'),
                        'field' => 'name',
                        'route' => ['name' => 'admin.attributes.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.measure'),
                        'field' => 'measure',
                        'route' => ['name' => 'admin.attributes.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($attributes as $key => $attribute)
                <tr>
                    <th scope="row" class="fw-normal">{{ $attributes->firstItem() + $key }}</th>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->measure }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.attributes.edit', $attribute) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteAttributeModal{{ $attribute->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.attributes.partials.delete')
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
