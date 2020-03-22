<h4>Вопрос эксперту:</h4>
<p>Имя:{{ $data->user->name }}</p>,
<p>Телефон: {{ $data->user->phone }}</p>
<p>E-mail: {{ $data->user->email }}</p>
@if ($data->message)
    <h4>Сообщение:</h4>
    <p>{{ $data->message }}</p>
@endif

<br>
<p>-----<br>{{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>