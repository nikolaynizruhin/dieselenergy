@switch($order->status)
    @case($order::NEW)
        @include('admin.layouts.partials.status', ['status' => $order->status, 'type' => 'primary'])
        @break

    @case($order::PENDING)
        @include('admin.layouts.partials.status', ['status' => $order->status, 'type' => 'warning'])
        @break

    @case($order::DONE)
        @include('admin.layouts.partials.status', ['status' => $order->status, 'type' => 'success'])
        @break
@endswitch
