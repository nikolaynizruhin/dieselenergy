<div class="row">
    <div class="col-md-4">
        @include('layouts.partials.search', ['url' => route('orders.show', $order)])
    </div>
    <div class="col text-right">
        <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('carts.create', ['order_id' => $order->id]) }}" role="button">{{ __('Attach Product') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('carts.partials.'.($products->total() ? 'list' : 'empty'))
</div>
