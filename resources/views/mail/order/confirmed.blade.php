@component('mail::message')
Номер Вашого замовлення: **#{{ $order->id }}**

@component('mail::table')
| #                      | Назва                | Ціна                      | К-сть                           | Загалом                                               |
| ---------------------- | -------------------- |--------------------------:|:-------------------------------:|------------------------------------------------------:|
@foreach($order->products as $product)
| {{ $loop->iteration }} | {{ $product->name }} | @uah($product->uah_price) | {{ $product->pivot->quantity }} | @uah($product->pivot->quantity * $product->uah_price) |
@endforeach
@endcomponent

**Всього: @uah($order->total())**


З повагою,<br>
{{ config('app.name') }}
@endcomponent
