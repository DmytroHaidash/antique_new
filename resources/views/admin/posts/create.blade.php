@extends('layouts.admin', ['page_title' => 'Новая запись'])

@section('content')

    <section>
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Новая запись">
                        @foreach(config('app.locales') as $lang)

                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Заголовок</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') }}">
                                    @if($errors->has('title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Краткое описание</label>
                                    <textarea name="{{$lang}}[description]" id="description" class="form-control"
                                              rows="4">{{ old($lang.'.description') }}</textarea>
                                </div>

                                <wysiwyg label="Текст записи" name="{{$lang}}[body]" content="{{old($lang.'.body')}}"
                                         class="mb-0"></wysiwyg>
                            </fieldset>

                        @endforeach
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => null])
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="category">Категория</label>
                        <ul class="list-unstyled">
                            @foreach($categories as $category)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="category_{{$category->id}}" name="category_id[]"
                                               value="{{ $category->id }}">
                                        <label class="custom-control-label font-weight-bold"
                                               for="category_{{$category->id}}">
                                            {{ $category->title }}
                                        </label>
                                    </div>
                                </li>

                                @if ($category->children->count())
                                    @foreach($category->children as $child)
                                        <li class="ml-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="category_{{$child->id}}" name="category_id[]"
                                                       value="{{ $child->id }}">
                                                <label class="custom-control-label" for="category_{{$child->id}}">
                                                    {{ $child->title }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="video" class="mt-2">Видео</label>
                        <input id="video" type="text" name="video"
                               class="form-control"
                               value="{{ old('video') }}">
                    </div>
                    <div class="form-group">
                        <label for="published_at">Дата публикации</label>
                        <input type="datetime-local" class="form-control" name="published_at" id="published_at"
                               value="{{ old('published_at') ?? now()->format('Y-m-d\TH:i') }}">
                    </div>

                    <div class="form-group">
                        <label>Миниатюра записи</label>
                        <single-uploader name="cover"></single-uploader>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>

                <div class="ml-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="published" name="published" checked>
                        <label class="custom-control-label" for="published">Опубликовать</label>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection