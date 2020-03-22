@extends('layouts.admin', ['page_title' => 'Редактирование страницы'])

@section('content')

    <section>
        <form action="{{ route('admin.pages.update', $page) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редактирование страницы">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') ?? $page->getTranslation('title', $lang) }}">
                                    @if($errors->has('title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>

                                <wysiwyg label="Текст записи" name="{{$lang}}[body]"
                                         content="{{ old($lang.'.body') ?? $page->getTranslation('body', $lang) }}"
                                         class="mb-0"></wysiwyg>
                            </fieldset>
                        @endforeach

                        {{--
                        @if ($pages->count())
                            <div class="form-group">
                                <label for="category">Родительская страница</label>
                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">-----</option>
                                    @foreach($pages as $pg)
                                        <option value="{{ $pg->id }}"
                                                {{ $page->parent_id == $pg->id ? 'selected' : '' }}>
                                            {{ $pg->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        --}}
                    </block-editor>
                    <div class="ml-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="published" name="published" {{ $page->published ? 'checked' : '' }}>
                            <label class="custom-control-label" for="published">Опубликовать</label>
                        </div>
                    </div>

                    @includeIf('partials.admin.meta', ['meta' => $page->meta()->first()])
                </div>

                <div class="col-lg-4">
                    <single-uploader name="cover"
                                     src="{{ optional($page->getFirstMedia('cover'))->getFullUrl() }}"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection