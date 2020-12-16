@extends('layouts.admin', ['page_title' => $product->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-9">
                    <block-editor title="{{ $product->translate('title') }}">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Название товара</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') ?? $product->translate('title', $lang) }}"
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
                                           name="{{$lang}}[description]"
                                           value="{{ old($lang.'.description') ?? $product->translate('description', $lang) }}">
                                </div>

                                <label>Полное описание товара</label>
                                <wysiwyg name="{{$lang}}[body]" class="mb-0"
                                         content="{{ old($lang.'.body') ?? $product->translate('body', $lang) }}"></wysiwyg>
                            </fieldset>
                        @endforeach
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => $product->meta()->first()])
                    <multi-uploader class="mt-4"
                            :src="{{ json_encode(\App\Http\Resources\MediaResource::collection($product->getMedia('uploads'))) }}"></multi-uploader>
                </div>

                <div class="col-lg-3">
                    <div class="form-group{{ $errors->has('price') ? ' is-invalid' : '' }}">
                        <label for="price">Цена</label>
                        <input type="number" min="0.01" step="0.01" class="form-control" id="price" name="price"
                               value="{{ old('price') ?? $product->price }}" required>
                        @if($errors->has('price'))
                            <div class="mt-1 text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="custom-control custom-checkbox ml-3">
                        <input type="checkbox" class="custom-control-input"
                               id="publish_price" name="publish_price"
                            {{ $product->publish_price ? 'checked' : '' }}>
                        <label class="custom-control-label" for="publish_price">Опубликовать цену</label>
                    </div>
                    <div class="custom-control custom-checkbox ml-3">
                        <input type="checkbox" class="custom-control-input"
                               id="ask_price" name="ask_price"
                                {{ $product->ask_price ? 'checked' : '' }}>
                        <label class="custom-control-label" for="ask_price">Запросить цену</label>
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
                                                       {{ in_array($child->id, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}
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
                           id="stock" name="in_stock" value="stock" {{$product->in_stock == 'stock' ? 'checked' : ''}}>
                    <label class="custom-control-label" for="stock">Есть в наличии</label>
                </div>
                <div class="custom-control custom-checkbox ml-3">
                    <input type="radio" class="custom-control-input"
                           id="reserved" name="in_stock" value="reserved" {{$product->in_stock == 'reserved' ? 'checked' : ''}}>
                    <label class="custom-control-label" for="reserved">Зарезервирровано</label>
                </div>
                <div class="custom-control custom-checkbox ml-3">
                    <input type="radio" class="custom-control-input"
                           id="sold" name="in_stock" value="sold" {{$product->in_stock == 'sold' ? 'checked' : ''}}>
                    <label class="custom-control-label" for="sold">Продано</label>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>

                <div class="custom-control custom-checkbox ml-3">
                    <input type="checkbox" class="custom-control-input"
                           id="published" name="is_published"
                            {{ $product->is_published ? 'checked' : '' }}>
                    <label class="custom-control-label" for="published">Опубликовать</label>
                </div>
            </div>
            @if(\Auth::user()->hasRole('admin'))
                <h2 class="mt-4">Бухгалтерия</h2>
                @if($statuses->count() > 0 && $suppliers->count() > 0)
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="date">Дата</label>
                            <input type="date" id="date" class="form-control" name="accountings[date]"
                                   value="{{ $product->accountings->date ?? date("Y-m-d") }}" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="status">Статус</label>
                            <select name="accountings[status_id]" id="status" class="form-control">
                                <option value="">-------</option>
                                @foreach($statuses as $status)
                                    <option
                                            value="{{ $status->id }}" {{ $product->accountings ? ($status->id === $product->accountings->status_id ? 'selected' : ''): '' }}>
                                        {{ $status->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="supplier">Поставщик</label>
                            <select name="accountings[supplier_id]" id="supplier" class="form-control">
                                <option value="">-------</option>
                                @foreach($suppliers as $supplier)
                                    <option
                                            value="{{ $supplier->id }}" {{ $product->accountings ? ($supplier->id === $product->accountings->supplier_id ? 'selected' : ''): '' }}>
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
                                    <option value="{{ $buer->id }}"
                                        {{ $product->accountings ? ($supplier->id === $product->accountings->buer_id ? 'selected' : ''): '' }}>
                                        {{ $buer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="new-buer">Новый Покупатель</label>
                            <input type="text" class="form-control" id="new-buer" name="new-buer">
                        </div>
                        <div class="form-group col-4">
                            <label for="whom">Чье</label>
                            <input type="text" class="form-control" id="whom" name="accountings[whom]"
                                   value="{{ $product->accountings->whom ?? '' }}">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="sell_price">Цена</label>
                            <input type="number" min="0" step="1" class="form-control" id="sell_price" name="accountings[sell_price]"
                                   value="{{ $product->accountings->sell_price ?? '' }}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="sell_date">Дата продажи</label>
                            <input type="date" id="sell_date" class="form-control" name="accountings[sell_date]"
                                   value="{{ $product->accountings->sell_date ?? '' }}">
                        </div>
                    </div>
                    <accountings :message="{{$product->accountings->message ?? "['']"}}"
                                 :price="{{$product->accountings->price ?? "['0']" }}"></accountings>
                    <div class="form-group col-12">
                        <label for="comment">Заметки</label>
                        <textarea name="accountings[comment]" class="form-control"
                                  id="comment">{{$product->accountings->comment ?? ""}}</textarea>
                    </div>
                    @if($product->accountings)
                        <multi-uploader name="accounting" class="mt-4"
                                              :src="{{  json_encode($product->accountings->images_list) }}"></multi-uploader>
                    @else
                        <multi-image-uploader name="accounting" class="mt-4"></multi-image-uploader>
                    @endif
                    @if($product->accountings && $product->accountings->hasMedia('uploads'))
                        <div class="d-flex align-items-center mt-4">
                            <a href="{{route('admin.accounting.pdf', $product)}}" class="btn btn-outline-primary">Скачать
                                изображения</a>
                        </div>
                    @endif
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
