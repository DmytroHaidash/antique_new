@extends('layouts.admin', ['page_title' => 'Редактирование места проведения'])

@section('content')

    <section>
        <form action="{{ route('admin.places.update', $place) }}" method="post">
            @csrf
            @method('patch')

            <block-editor title="Редактирование места проведения">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group">
                            <label for="title">Название</label>
                            <input id="title" type="text" name="{{$lang}}[title]"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   value="{{ old($lang.'.title') ?? $place->getTranslation('title', $lang) }}">
                            @if($errors->has('title'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <wysiwyg label="Описание" name="{{$lang}}[body]"
                                     content="{{ old($lang.'.body') ?? $place->getTranslation('body', $lang) }}"
                                     class="mb-0"></wysiwyg>
                        </div>
                    </fieldset>
                @endforeach
            </block-editor>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection