@extends('layouts.admin', ['page_title' => 'Новый товар'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-9">
                    <block-editor title="Новый товар">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Название товара</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') }}"
                                           required>
                                    @if($errors->has($lang.'.title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Краткое описание товара</label>
                                    <input type="text" class="form-control" id="description"
                                           name="{{$lang}}[description]" value="{{ old($lang.'.description') }}">
                                </div>

                                <label>Полное описание товара</label>
                                <wysiwyg name="{{$lang}}[body]" class="mb-0"
                                         content="{{ old($lang.'.body') }}"></wysiwyg>
                            </fieldset>
                        @endforeach
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => null])
                    <multi-uploader class="mt-4"></multi-uploader>
                </div>

                <div class="col-lg-3">
                    <div class="form-group{{ $errors->has('price') ? ' is-invalid' : '' }}">
                        <label for="price">Цена</label>
                        <input type="number" min="1" step="1" class="form-control" id="price" name="price"
                               value="{{ old('price') }}" required>
                        @if($errors->has('price'))
                            <div class="mt-1 text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group my-4">
                        <div class="custom-control custom-checkbox ml-3">
                            <input type="checkbox" class="custom-control-input"
                                   id="publish_price" name="publish_price" checked>
                            <label class="custom-control-label" for="publish_price">Опубликовать цену</label>
                        </div>
                        <div class="custom-control custom-checkbox ml-3">
                            <input type="checkbox" class="custom-control-input"
                                   id="ask_price" name="ask_price">
                            <label class="custom-control-label" for="ask_price">Запросить цену</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="section">Категория</label>
                        <ul class="list-unstyled">
                            @foreach($categories as $section)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        {{ $section->title }}
                                    </div>
                                </li>

                                @if ($section->children->count())
                                    @foreach($section->children as $child)
                                        <li class="ml-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="category-{{$child->id}}" name="categories[]"
                                                       value="{{ $child->id }}">
                                                <label class="custom-control-label" for="category-{{$child->id}}">
                                                    {{ $child->title }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex my-4">
                <div class="custom-control custom-checkbox ml-3">
                    <input type="radio" class="custom-control-input"
                               id="stock" name="in_stock" value="stock"checked>
                    <label class="custom-control-label" for="stock">Есть в наличии</label>
                </div>
                <div class="custom-control custom-checkbox ml-3">
                    <input type="radio" class="custom-control-input"
                           id="reserved" name="in_stock" value="reserved">
                    <label class="custom-control-label" for="reserved">Зарезервирровано</label>
                </div>
                <div class="custom-control custom-checkbox ml-3">
                    <input type="radio" class="custom-control-input"
                           id="sold" name="in_stock" value="sold">
                    <label class="custom-control-label" for="sold">Продано</label>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>

                <div class="custom-control custom-checkbox ml-3">
                    <input type="checkbox" class="custom-control-input"
                           id="published" name="is_published" checked>
                    <label class="custom-control-label" for="published">Опубликовать</label>
                </div>
            </div>
            @if(\Auth::user()->hasRole('admin'))
                <h2 class="mt-4">Бухгалтерия</h2>
                @if($statuses->count() > 0 && $suppliers->count() > 0)
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="date">Дата</label>
                            <input type="date" id="date" class="form-control" name="accountings[date]"
                                   value="{{date("Y-m-d")}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="status">Статус</label>
                            <select name="accountings[status_id]" id="status" class="form-control">
                                <option value="">-------</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">
                                        {{ $status->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="supplier">Поставщик</label>
                            <select name="accountings[supplier_id]" id="supplier" class="form-control">
                                <option value="">-------</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="new-supplier">Новый поставщик</label>
                            <input type="text" class="form-control" id="new-supplier" name="new-supplier">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="buer">Покупатель</label>
                            <select name="accountings[buer_id]" id="buer" class="form-control">
                                <option value="">-------</option>
                                @foreach($buers as $buer)
                                    <option value="{{ $buer->id }}">
                                        {{ $buer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="new-buer">Новый Покупатель</label>
                            <input type="text" class="form-control" id="new-buer" name="new-buer">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="whom">Чье</label>
                            <input type="text" class="form-control" id="whom" name="accountings[whom]">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="sell_price">Цена</label>
                            <input type="number" min="1" step="1" class="form-control" id="sell_price"
                                   name="accountings[sell_price]">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="sell_date">Дата продажи</label>
                            <input type="date" id="sell_date" class="form-control" name="accountings[sell_date]">
                        </div>

                    </div>

                    <accountings :message="['']" :price="['0']"></accountings>


                    <div class="form-group col-12">
                        <label for="comment">Заметки</label>
                        <textarea name="accountings[comment]" class="form-control" id="comment"></textarea>
                    </div>
                    <multi-uploader name="accounting" class="mt-4"></multi-uploader>
                    <div class="d-flex align-items-center mt-4">
                        <button class="btn btn-primary">Сохранить</button>
                    </div>
                @else
                    <p>Для ведения бухгалтерии сначала создайте:
                        @if($suppliers->count() == 0)
                            <a href="{{route('admin.suppliers.create')}}"
                               class="btn btn-outline-primary">Поставщиков</a>
                        @endif
                        @if($statuses->count() == 0)
                            <a href="{{route('admin.statuses.create')}}" class="btn btn-outline-primary">Cтатусы</a>
                        @endif
                    </p>
                @endif
            @endif
        </form>
    </section>

@endsection
