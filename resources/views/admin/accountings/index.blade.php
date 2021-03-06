@extends('layouts.admin', ['page_title' => 'Бухгалтерия'])

@section('content')
    <section id="content">
        <div class="d-flex align-items-center">
            <h1 class="h3 mb-0">Бухгалтерия</h1>
        </div>
        @if(request()->route()->getName() == 'admin.accounting.index')
            @if(request('status') || request('supplier') || request('buer') || request('q'))
                <a href="{{ route('admin.accounting.index') }}"
                   class="btn mt-2 btn-outline-primary mb-2">
                    Сбросить фильтры
                </a>
            @endif
            @if($statuses->count())
                <div class="mb-2">
                    <p class="mb-0">Фильтрация по статусу:</p>
                    @foreach($statuses as $status)
                        <a href="?status={{ $status->id }}"
                           class="btn mr-2  mt-2 btn-{{ request('status') == $status->id ? 'primary' : 'outline-primary' }}">
                            {{$status->title}}
                        </a>
                    @endforeach
                </div>
            @endif
            @if($suppliers->count())
                <div class="mb-2">
                    <p class="mb-0">Фильтрация по поставщику:</p>
                    @foreach($suppliers as $supplier)
                        <a href="?supplier={{ $supplier->id }}"
                           class="btn mr-2 mt-2 btn-{{ request('supplier') == $supplier->id ? 'primary' : 'outline-primary' }}">
                            {{$supplier->title}}
                        </a>
                    @endforeach
                </div>
            @endif
            @if($buers->count())
                <div class="mb-2">
                    <p class="mb-0">Фильтрация по покупателю:</p>
                    @foreach($buers as $buer)
                        <a href="?buer={{ $supplier->id }}"
                           class="btn mr-2 mt-2 btn-{{ request('buer') == $buer->id ? 'primary' : 'outline-primary' }}">
                            {{$buer->title}}
                        </a>
                    @endforeach
                </div>
            @endif
        @endif
        <form action="{{route('admin.accounting.filter')}}" class="my-4" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="year">Фильтрация по году:</label>
                    <input type="number" min="2019" max="{{ date('Y') }}" step="1"
                           name="year" id="year" class="form-control"
                           @if(request()->route()->getName() == 'admin.accounting.filter')
                           value="{{$request['year']}}"
                           @endif
                           required/>

                </div>
                <div class="col-sm-4 form-group">
                    <label for="month">Фильтрация по месяцу (1-12):</label>
                    <input type="number" min="1" max="12" step="1" name="month" id="month" class="form-control"
                           @if(request()->route()->getName() == 'admin.accounting.filter')
                               @if($request['month'])
                                value="{{$request['month']}}"
                           @endif
                        @endif
                    />
                </div>
                <div class="col-auto mt-4">
                    <button class="btn btn-primary">Фильтровать</button>
                    @if(request()->route()->getName() == 'admin.accounting.filter')
                        <a href="{{ route('admin.accounting.index') }}"
                           class="btn btn-outline-primary ml-3">
                            Сбросить фильтр
                        </a>
                    @endif
                </div>

            </div>
        </form>
        <form class="my-4 d-flex">
            <div class="mr-2 flex-grow-1">
                <input type="text" name="q" value="{{ request()->get('q', null) }}" class="form-control"
                       placeholder="Поиск по товарам">
            </div>
            <button class="btn btn-primary">
                <i class="i-search"></i>
                Найти
            </button>
        </form>
        @if(request()->route()->getName() == 'admin.accounting.filter')
            <p>Общие затраты за выбраный период: {{$amountAcc}}</p>
            <p>За выбраный период продано товаров на сумму: {{$amountSell}}</p>
            <p>Общая прибыль за выбраный период: {{$amountSell - $amountAcc}}</p>
        @else
            <p>Общая стоимость товаров: {{$amountProduct}}</p>
            <p>Общая себестоимость товаров по которым ведется учет: {{$amountAcc}}</p>
            <p>Общая стоимость опубликованых товаров: {{$amountPublishedProduct}}</p>
            <p>Общая себестоимость опубликованых товаров по которым ведется учет: {{$amountPublishedAcc}}</p>
        @endif

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th class="text-center">Название</th>
                <th class="text-center">Статус</th>
                <th class="text-center">Поставщик</th>
                <th class="text-center">Чье</th>
                <th class="text-center">Покупатель</th>
                <th class="text-center">{{request()->route()->getName() == 'admin.accounting.filter' ? 'Прибыль' : 'Себестоимость'}}</th>
                <th></th>
            </tr>
            </thead>
            @forelse($accountings as $accounting)
                <tr>
                    <td width="200" class="text-center">
                        <a href="{{ route('admin.products.edit', $accounting->product) }}" class="underline">
                            {{ $accounting->product->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $accounting->status->title ?? '' }}
                    </td>
                    <td class="text-center">{{ $accounting->supplier->title ?? '' }}</td>
                    <td class="text-center">{{ $accounting->whom }}</td>
                    <td class="text-center">{{ $accounting->buer->title ?? '' }}</td>
                    <td width="100" class="small text-center">
                        @if(request()->route()->getName() == 'admin.accounting.filter')
                            {{$accounting->sell_price - $accounting->amount}}
                        @else
                            {{$accounting->amount}}
                        @endif
                    </td>
                    <td width="100" class="text-right">
                        <a href="{{ route('admin.products.edit', $accounting->product) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        @if(request()->filled('status'))
                            Записей с таким статусом нет
                        @elseif(request()->filled('supplier'))
                            Записей с этим поставщиком нет
                        @elseif(request()->filled('buer'))
                            Записей с этим покупателем нет
                        @else
                            Бухгалтерия пока не ведется
                        @endif
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $accountings->appends(request()->except('page'))->links() }}
    </section>

@endsection
