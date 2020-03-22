@extends('layouts.admin', ['page_title' => 'Новый экспонат'])

@section('content')

    <section>
        <form action="{{ route('admin.exhibits.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Новый экспонат">
                        @foreach(config('app.locales') as $lang)

                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="title">Заголовок</label>
                                    <input id="title" type="text" name="{{$lang}}[title]"
                                           class="form-control{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.title') }}">
                                </div>

                                <hr class="mt-4">

                                <div class="row">
                                    @foreach(\App\Models\Exhibit::$props as $prop)
                                        <div class="col-md-6 form-group">
                                            <label>{{ __('exhibits.props.'.$prop) }}</label>
                                            <input type="text" class="form-control" name="{{$lang}}[props][{{$prop}}]"
                                                   value="{{ old($lang.'.props.'.$prop) }}">
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="mb-4">

                                <wysiwyg label="Текст записи" name="{{$lang}}[body]" content="{{old($lang.'.body')}}"
                                         class="mb-0"></wysiwyg>
                            </fieldset>

                        @endforeach
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => null])
                </div>

                <div class="col-lg-4">
                    {{--<div class="form-group">
                        <label for="author">Автор <small>(не обязательно)</small></label>
                        <select name="author_id" id="author" class="form-control">
                            <option value="">Не задан</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>--}}

                    <div class="form-group">
                        <label for="section">Категория</label>
                        <ul class="list-unstyled">
                            @foreach($sections as $section)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="section_{{$section->id}}" name="section_id[]"
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
                <multi-uploader></multi-uploader>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection