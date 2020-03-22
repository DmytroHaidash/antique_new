@extends('layouts.admin', ['page_title' => 'Заказы'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Заказы</h1>
        </div>

        <table class="table">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Контакт</th>
                <th>Товар</th>
                <th>Статус заказа</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($orders as $order)
                <tr>
                    <td width="20">{{ $order->id }}</td>
                    <td>

                        <h5 class="position-relative">
                            <div class="indicator bg-warning"></div>
                            {{ $order->name }}
                        </h5>
                        @foreach(json_decode($order->contact) as $item)
                            <p class="mb-0">{{ $item }}</p>
                        @endforeach

                    </td>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $order->product->getFirstMediaUrl('products', 'thumb') }}" width="50"
                                     alt="">
                            </div>
                            <div class="flex-grow-0">
                                <h5>
                                    <a href="{{ route('client.catalog.show', $order->product) }}" class="underline"
                                       target="_blank">
                                        {{ $order->product->translate('title') }}
                                    </a>
                                </h5>
                                <h5>
                                    {{ $order->price }} грн.
                                    <small class="text-muted">
                                        ({{ $order->product->price }} грн.)
                                    </small>
                                </h5>
                            </div>
                        </div>
                    </td>
                    <td width="150">
                        <select name="status" class="form-control"
                                onchange="updateStatus('{{ route('admin.orders.update', $order) }}')">
                            @foreach(\App\Models\Order::$STATUSES as $status)
                                <option value="{{ $status }}"
                                        {{ $order->status == $status ? 'selected' : '' }}>
                                    @lang('orders.statuses.'.$status)
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td width="150">{{ $order->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="50">
                        <a href="{{ route('admin.orders.edit', $order) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Заказов пока нет
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $orders->appends(request()->except('page'))->links() }}
    </section>

    <form id="status" method="post" style="display: none;">
        @csrf
        @method('patch')
        <input type="hidden" name="status">
    </form>

@endsection

@push('scripts')
    <script>
      function updateStatus(route) {
        const form = document.getElementById('status');
        form.setAttribute('action', route);
        form.querySelector('[name="status"]').value = event.target.value;
        form.submit();
      }
    </script>
@endpush