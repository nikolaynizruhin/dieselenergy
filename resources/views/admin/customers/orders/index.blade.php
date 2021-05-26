<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.customers.show', $customer), 'name' => 'search[order]', 'value' => 'search.order'])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.orders.create', ['customer_id' => $customer->id]) }}" role="button">{{ __('order.add') }}</a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    @include('admin.orders.partials.'.($orders->isEmpty() ? 'empty' : 'list'), [
        'route' => [
            'name' => 'admin.customers.show',
            'parameters' => ['customer' => $customer]
        ],
        'nested' => 'order'
    ])
</div>
