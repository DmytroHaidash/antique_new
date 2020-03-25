<h4>Новый подписчик</h4>
<p>Имя:{{ $data->subscribe_first_name }}</p>
<p>Фамилия:{{ $data->subscribe_last_name }}</p>
@if($data->subscribe_email)
<p>email:{{ $data->subscribe_email }}</p>
@endif
@if($data->subscribe_phone)
<p>Телефон:{{ $data->subscribe_phone }}</p>
@endif
<br>
<p>-----<br>{{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>
