<div class="card-header text-muted bg-white lead">
    {{ __('product.plural') }}
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
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.quantity'),
                        'field' => 'quantity',
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.price'),
                        'field' => 'total',
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($products as $key => $product)
                <tr>
                    <th scope="row" class="fw-normal">{{ $products->firstItem() + $key }}</th>
                    <td>
                        <a href="{{ route('admin.products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td class="text-nowrap">@uah($product->pivot->quantity * $product->price->toUAH()->coins())</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.carts.edit', $product->pivot->id) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteCartModal'.$product->id,
                            'label' => 'deleteCartLabel'.$product->id,
                            'title' => __('cart.delete'),
                            'body' => __('common.alert.detach').' '.$product->name.'?',
                            'action' => route('admin.carts.destroy', $product->pivot->id),
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
        {{ __('common.total') }} {{ $products->total() }} {{ __('common.records') }}
        {{ $products->links() }}
    </div>
</div>
