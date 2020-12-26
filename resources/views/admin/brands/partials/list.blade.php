<div class="card-header text-muted bg-white lead">
    {{ __('brand.plural') }}
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
                        'route' => ['name' => 'admin.brands.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.title'),
                        'field' => 'currencies.code',
                        'route' => ['name' => 'admin.brands.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($brands as $key => $brand)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $brands->firstItem() + $key }}</th>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->currency->code }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteBrandModal{{ $brand->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.brands.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $brands->total() }} {{ __('common.records') }}
        {{ $brands->withQueryString()->links() }}
    </div>
</div>
