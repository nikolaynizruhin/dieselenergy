<div class="card-header text-muted bg-white lead">
    {{ __('product.plural') }}
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
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.quantity'),
                        'field' => 'quantity',
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.price'),
                        'field' => 'total',
                        'route' => ['name' => 'admin.orders.show', 'parameters' => ['order' => $order]],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($products as $key => $product)
                <tr>
                    <th scope="row" class="fw-normal">{{ $products->firstItem() + $key }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td class="text-nowrap">@uah($product->pivot->quantity * $product->uah_price)</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.carts.edit', $product->pivot->id) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteCartModal{{ $product->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.carts.partials.delete')
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
        {{ $products->withQueryString()->links() }}
    </div>
</div>
