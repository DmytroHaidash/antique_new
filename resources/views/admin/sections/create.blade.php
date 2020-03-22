@extends('layouts.admin', ['page_title' => 'Новая секция'])

@section('content')

    <section>
        <form action="{{ route('admin.sections.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Секция">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Название</label>
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
                                    <textarea rows="3" name="{{$lang}}[description]" class="form-control">{{ old($lang.'.description') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Описание <small class="text-muted">(не обязательно)</small></label>
                                    <wysiwyg name="{{$lang}}[body]" content="{{ old($lang.'.body') }}"></wysiwyg>
                                </div>
                            </fieldset>
                        @endforeach

                        @if ($sections->count())
                            <div class="form-group">
                                <label for="category">Родительская секция</label>
                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">-----</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">
                                            {{ $section->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => null])
                </div>

                <div class="col-lg-4">
                    {{--
                    <div class="form-group">
                        <label for="related">Относится к</label>
                        <select name="type" id="related" class="form-control">
                            @foreach(['exhibit', 'publication'] as $type)
                                <option value="{{ $type }}">
                                    {{ $type === 'exhibit' ? 'Колекциям' : 'Публикациям' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    --}}

                    <label>Миниатюра записи</label>
                    <single-uploader name="cover"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection