<div class="card-header text-muted lead">
    {{ __('brand.plural') }}
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
                        'route' => ['name' => 'admin.brands.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.title'),
                        'field' => 'currencies.code',
                        'route' => ['name' => 'admin.brands.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($brands as $key => $brand)
                <tr>
                    <th scope="row" class="fw-normal">{{ $brands->firstItem() + $key }}</th>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->currency->code }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteBrandModal'.$brand->id,
                            'label' => 'deleteBrandLabel'.$brand->id,
                            'title' => __('brand.delete'),
                            'body' => __('common.alert.delete').' '.$brand->name.'?',
                            'action' => route('admin.brands.destroy', $brand),
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
        {{ __('common.total') }} {{ $brands->total() }} {{ __('common.records') }}
        {{ $brands->links() }}
    </div>
</div>
