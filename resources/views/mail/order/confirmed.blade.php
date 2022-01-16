@component('mail::message')
Номер Вашого замовлення: **#{{ $order->id }}**

@component('mail::table')
| #                      | Назва                | Ціна                      | К-сть                           | Загалом                                               |
| ---------------------- | -------------------- |--------------------------:|:-------------------------------:|------------------------------------------------------:|
@foreach($order->products as $product)
| {{ $loop->iteration }} | {{ $product->name }} | {{ $product->price->toUAH()->format() }} | {{ $product->pivot->quantity }} | @uah($product->pivot->quantity * $product->price->toUAH()->coins()) |
@endforeach
@endcomponent

**Всього: @uah($order->getTotal())**


З повагою,<br>
{{ config('app.name') }}
@endcomponent
