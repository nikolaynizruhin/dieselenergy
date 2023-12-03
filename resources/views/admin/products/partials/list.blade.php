<div class="card-header text-muted lead">
    {{ __('product.plural') }}
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
                            'route' => ['name' => 'admin.products.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('category.title'),
                            'field' => 'categories.name',
                            'route' => ['name' => 'admin.products.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('common.status'),
                            'field' => 'status',
                            'route' => ['name' => 'admin.products.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('common.price'),
                            'field' => 'price',
                            'route' => ['name' => 'admin.products.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-muted">
                @foreach ($products as $key => $product)
                    <tr>
                        <th scope="row" class="fw-normal">{{ $products->firstItem() + $key }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @include('admin.layouts.partials.status', [
                                'status' => $product->is_active ? __('common.active') : __('Inactive'),
                                'type' => $product->is_active ? 'success' : 'danger',
                            ])
                        </td>
                        <td class="text-nowrap">{{ $product->price->toUAH()->format() }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.products.show', $product) }}" class="me-2 text-decoration-none">
                                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="me-2 text-decoration-none">
                                @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            @include('admin.layouts.partials.delete', [
                                'id' => 'deleteProductModal'.$product->id,
                                'label' => 'deleteProductLabel'.$product->id,
                                'title' => __('product.delete'),
                                'body' => __('common.alert.delete').' '.$product->name.'?',
                                'action' => route('admin.products.destroy', $product),
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
        {{ __('common.total') }} {{ $products->total() }} {{ __('common.records') }}
        {{ $products->links() }}
    </div>
</div>
