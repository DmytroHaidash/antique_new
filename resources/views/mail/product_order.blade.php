<h4>Заказчик:</h4>
@if ($order->user)
    <p>{{ $order->user->name }}, {{ $order->user->phone }} <{{ $order->user->email }}></p>
@else
    <p>{{ $order->name }}, {{ $order->contact }}</p>
@endif

<h4>Товар:</h4>
<p>
    <a href="{{ route('client.catalog.show', $order->product) }}" target="_blank">{{ $order->product->title }}</a>
</p>

@if ($order->message)
    <h4>Сообщение:</h4>
    <p>{{ $order->message }}</p>
@endif

<br>
<p>-----<br>{{ $order->created_at->formatLocalized('%d %B %Y') }}</p>