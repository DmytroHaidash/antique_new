<h4>Заказ книги:</h4>
<p>Имя:{{ $data['user']->name }}</p>
<p>email:{{ $data['user']->email }}</p>
<p>Телефон:{{ $data['user']->phone }}</p>
<br>
<p>-----<br>{{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>