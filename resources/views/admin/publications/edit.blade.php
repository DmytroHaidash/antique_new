@extends('layouts.admin', ['page_title' => 'Редктирование экспоната'])

@section('content')

    <section>
        <form action="{{ route('admin.exhibits.update', $exhibit) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редктирование экспоната">
                        @foreach(config('app.locales') as $lang)

                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Заголовок</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') ?? $exhibit->getTranslation('title', $lang) }}">
                                </div>

                                <hr class="mt-4">

                                <div class="row">
                                    @foreach(\App\Models\Exhibit::$props as $prop)
                                        <div class="col-md-6 form-group">
                                            <label>{{ __('exhibits.props.'.$prop) }}</label>
                                            <input type="text" class="form-control" name="{{$lang}}[props][{{$prop}}]"
                                                   value="{{ old($lang.'.props.'.$prop) ?? $exhibit->getTranslation('props', $lang)[$prop] }}">
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="mb-4">

                                <wysiwyg label="Текст записи" name="{{$lang}}[body]" class="mb-0"
                                         content="{{ old($lang.'.body') ?? $exhibit->getTranslation('body', $lang) }}"></wysiwyg>
                            </fieldset>

                        @endforeach
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <select name="author_id" id="author" class="form-control">
                            <option value="">Не задан</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}"
                                        {{ $exhibit->author_id == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="section">Категория</label>
                        <ul class="list-unstyled">
                            @foreach($sections as $section)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="section_{{$section->id}}" name="section_id[]"
                                               {{ in_array($section->id, $exhibit->sections->pluck('id')->toArray()) ? 'checked' : '' }}
                                               value="{{ $section->id }}">
                                        <label class="custom-control-label font-weight-bold"
                                               for="section_{{$section->id}}">
                                            {{ $section->title }}
                                        </label>
                                    </div>
                                </li>

                                @if ($section->children->count())
                                    @foreach($section->children as $child)
                                        <li class="ml-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="section_{{$child->id}}" name="section_id[]"
                                                       {{ in_array($child->id, $exhibit->sections->pluck('id')->toArray()) ? 'checked' : '' }}
                                                       value="{{ $child->id }}">
                                                <label class="custom-control-label" for="section_{{$child->id}}">
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

            <div class="mt-4">
                <multi-uploader
                        :src="{{ json_encode(\App\Http\Resources\MediaResource::collection($exhibit->getMedia('uploads'))) }}"></multi-uploader>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection