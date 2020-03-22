@extends('layouts.admin', ['page_title' => $section->title])

@section('content')

    <section>
        <form action="{{ route('admin.sections.update', $section) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Секция">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') ?? $section->getTranslation('title', $lang) }}">
                                    @if($errors->has('title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Краткое описание</label>
                                    <textarea rows="3" name="{{$lang}}[description]" class="form-control">{{ old($lang.'.description') ?? $section->getTranslation('description', $lang) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Описание</label>
                                    <wysiwyg name="{{$lang}}[body]"
                                             content="{{ old($lang.'.body') ?? $section->getTranslation('body', $lang) }}"></wysiwyg>
                                </div>
                            </fieldset>
                        @endforeach

                        @if ($sections->count())
                            <div class="form-group">
                                <label for="category">Родительская секция</label>
                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">-----</option>
                                    @foreach($sections as $sec)
                                        <option value="{{ $sec->id }}"
                                                {{ $section->parent_id == $sec->id ? 'selected' : '' }}>
                                            {{ $sec->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => $section->meta()->first()])
                </div>

                <div class="col-lg-4">
                    {{--
                    <div class="form-group">
                        <label for="related">Относится к</label>
                        <select name="type" id="related" class="form-control">
                            @foreach(['exhibit', 'publication'] as $type)
                                <option value="{{ $type }}"
                                        {{ $section->type == $type ? 'selected' : '' }}>
                                    {{ $type === 'exhibit' ? 'Колекциям' : 'Публикациям' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    --}}

                    <label>Миниатюра записи</label>
                    <single-uploader name="cover" src="{{ optional($section->getFirstMedia('cover'))->getFullUrl('thumb') }}"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection