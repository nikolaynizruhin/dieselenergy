@switch($order->status)
    @case($order::STATUS_NEW)
        <span class="badge badge-pill badge-primary">
            {{ $order->status }}
        </span>
    @break

    @case($order::STATUS_PENDING)
        <span class="badge badge-pill badge-warning">
            {{ $order->status }}
        </span>
    @break

    @case($order::STATUS_DONE)
        <span class="badge badge-pill badge-success">
            {{ $order->status }}
        </span>
    @break
@endswitch
