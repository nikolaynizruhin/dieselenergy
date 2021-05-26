<div class="card-header text-muted bg-white lead">
    {{ __('order.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr class="table-light">
                <th scope="col" class="text-muted border-bottom">#</th>
                @if ($route['name'] === 'admin.orders.index')
                    <th scope="col" class="text-muted border-bottom">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('customer.title'),
                            'field' => 'customers.name',
                            'route' => $route,
                            'nested' => $nested ?? null,
                        ])
                    </th>
                @endif
                <th scope="col" class="text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.number'),
                        'field' => 'id',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.status'),
                        'field' => 'status',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.date'),
                        'field' => 'created_at',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.total'),
                        'field' => 'total',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted border-bottom">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($orders as $key => $order)
                <tr>
                    <th scope="row" class="fw-normal">{{ $orders->firstItem() + $key }}</th>
                    @if ($route['name'] === 'admin.orders.index')
                        <td>
                            <a href="{{ route('admin.customers.show', $order->customer) }}">
                                {{ $order->customer->name }}
                            </a>
                        </td>
                    @endif
                    <td>{{ $order->id }}</td>
                    <td>
                        @include('admin.orders.partials.status')
                    </td>
                    <td class="text-nowrap">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-nowrap">@uah($order->total)</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.orders.show', $order) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteOrderModal{{ $order->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.orders.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $orders->total() }} {{ __('common.records') }}
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
