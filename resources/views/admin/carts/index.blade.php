<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.orders.show', $order)])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.carts.create', ['order_id' => $order->id]) }}" role="button">{{ __('product.attach') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @if ($products->isEmpty())
        @include('admin.layouts.partials.empty', [
            'body' => __('cart.missing'),
            'link' => route('admin.carts.create', ['order_id' => $order->id]),
            'button' => __('cart.add'),
        ])
    @else
        @include('admin.carts.partials.list')
    @endif
</div>
