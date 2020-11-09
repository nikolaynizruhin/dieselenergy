@component('mail::message')
### Ваше замовлення прийнято.

Наш менеджер зв'яжеться з Вами найближчим часом для уточнення деталей
Номер Вашого замовлення: #{{ $order->id }}

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent

З повагою,<br>
{{ config('app.name') }}
@endcomponent
