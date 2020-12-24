<div class="card-header text-muted bg-white lead">
    {{ __('order.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('customer.title') }}</th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.number'),
                       'field' => 'id',
                       'route' => $route,
                       'nested' => $nested,
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.status'),
                       'field' => 'status',
                       'route' => $route,
                       'nested' => $nested,
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.date'),
                       'field' => 'created_at',
                       'route' => $route,
                       'nested' => $nested,
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.total'),
                       'field' => 'total',
                       'route' => $route,
                       'nested' => $nested,
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($orders as $key => $order)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $orders->firstItem() + $key }}</th>
                    <td>
                        <a href="{{ route('admin.customers.show', $order->customer) }}">
                            {{ $order->customer->name }}
                        </a>
                    </td>
                    <td>{{ $order->id }}</td>
                    <td>
                        @include('admin.orders.partials.status')
                    </td>
                    <td class="text-nowrap">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-nowrap">@uah($order->total)</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.orders.show', $order) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteOrderModal{{ $order->id }}">
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
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $orders->total() }} {{ __('common.records') }}
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
