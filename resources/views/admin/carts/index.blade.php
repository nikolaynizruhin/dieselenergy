<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.orders.show', $order)])
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.carts.create', ['order_id' => $order->id]) }}" role="button">{{ __('product.attach') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('admin.carts.partials.'.($products->isEmpty() ? 'empty' : 'list'))
</div>
