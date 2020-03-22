<h4>Контакт:</h4>

<p>{{ $data->user->name }}, {{ $data->user->phone }}, {{ $data->user->email }}</p>

<h4>Товар:</h4>
<p>
    <a href="{{ route('client.catalog.show', $product) }}" target="_blank">{{ $product->title }}</a>
</p>

@if ($data->message)
    <h4>Сообщение:</h4>
    <p>{{ $data->message }}</p>
@endif

<br>
<p>-----<br>{{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>