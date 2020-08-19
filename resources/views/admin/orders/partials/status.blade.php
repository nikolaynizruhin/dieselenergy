@switch($order->status)
    @case($order::NEW)
        <span class="badge badge-pill badge-primary">
            {{ $order->status }}
        </span>
    @break

    @case($order::PENDING)
        <span class="badge badge-pill badge-warning">
            {{ $order->status }}
        </span>
    @break

    @case($order::DONE)
        <span class="badge badge-pill badge-success">
            {{ $order->status }}
        </span>
    @break
@endswitch
