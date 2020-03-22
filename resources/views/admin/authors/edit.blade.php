@extends('layouts.admin', ['page_title' => 'Редактирование автора'])

@section('content')

    <section>
        <form action="{{ route('admin.authors.update', $author) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редактирование автора">
                        @foreach(config('app.locales') as $lang)

                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Имя</label>
                                    <input id="title" type="text" name="{{$lang}}[name]"
                                           class="form-control{{ $errors->has($lang.'.name') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.name') ?? $author->getTranslation('name', $lang) }}">
                                </div>

                                <wysiwyg label="Текст записи" name="{{$lang}}[biography]"
                                         content="{{ old($lang.'.biography') ?? $author->getTranslation('biography', $lang) }}"
                                         class="mb-0"></wysiwyg>
                            </fieldset>

                        @endforeach
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Годы жизни</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="number" class="form-control" name="lives_from"
                                       value="{{ old('lives_from') ?? $author->lives_from }}" required>
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" name="lives_to"
                                       value="{{ old('lives_to') ?? $author->lives_to }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Миниатюра записи</label>
                        <single-uploader name="cover" src="{{ optional($author->getFirstMedia('cover'))->getFullUrl('thumb') }}"></single-uploader>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection