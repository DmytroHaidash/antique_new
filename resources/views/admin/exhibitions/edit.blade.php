@extends('layouts.admin', ['page_title' => 'Редактирование выставки'])

@section('content')

    <section>
        <form action="{{ route('admin.exhibitions.update', $exhibition) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редактирование выставки">
                        @foreach(config('app.locales') as $lang)

                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') ?? $exhibition->getTranslation('title', $lang) }}">
                                    @if($errors->has('title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Краткое описание</label>
                                    <textarea name="{{$lang}}[description]" id="description" class="form-control"
                                              rows="4">{{ old($lang.'.description') ?? $exhibition->getTranslation('description', $lang) }}</textarea>
                                </div>

                                <wysiwyg label="Полное описание" name="{{$lang}}[body]"
                                         content="{{ old($lang.'.body') ?? $exhibition->getTranslation('body', $lang) }}"
                                         class="mb-0"></wysiwyg>
                            </fieldset>

                        @endforeach
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="city">Город</label>
                        <select name="city_id" id="city" class="form-control">
                            <option value="">-----</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}"
                                {{ $city->id === $exhibition->city_id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="place">Место проведения</label>
                        <select name="place_id" id="place" class="form-control">
                            <option value="">-----</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}"
                                {{ $place->id == $exhibition->place_id ? 'selected' : '' }}>
                                    {{ $place->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Даты проведения</label>
                        <datepicker name="starts_at" date="{{ old('starts_at') ?? $exhibition->starts_at }}" class="mb-2"></datepicker>
                        <datepicker name="ends_at" date="{{ old('ends_at') ?? $exhibition->ends_at }}"></datepicker>
                    </div>

                    <div class="form-group">
                        <label>Миниатюра записи</label>
                        <single-uploader name="cover" src="{{ optional($exhibition->getFirstMedia('cover'))->getFullUrl() }}"></single-uploader>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection