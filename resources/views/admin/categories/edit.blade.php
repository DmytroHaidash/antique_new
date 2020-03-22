@extends('layouts.admin', ['page_title' => 'Редактирование категории'])

@section('content')

    <section>
        <form action="{{ route('admin.categories.update', $category) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редактирование категории">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') ?? $category->getTranslation('title', $lang) }}">
                                    @if($errors->has('title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание
                                        <small class="text-muted">(не обязательно)</small>
                                    </label>
                                    <textarea name="{{$lang}}[description]" id="description" class="form-control"
                                              rows="6">{{ old($lang.'.description') ?? $category->getTranslation('description', $lang) }}</textarea>
                                </div>
                            </fieldset>
                        @endforeach

                        {{--
                        @if ($categories->count())
                            <div class="form-group">
                                <label for="category">Родительская категория</label>
                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">-----</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                                {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        --}}
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <single-uploader name="cover"
                                     src="{{ optional($category->getFirstMedia('cover'))->getFullUrl('thumb') }}"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection