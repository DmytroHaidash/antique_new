@extends('layouts.admin', ['page_title' => 'Новая категория'])

@section('content')

    <section>
        <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Новая категория">
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
                                    <label for="description">Описание <small class="text-muted">(не обязательно)</small></label>
                                    <textarea name="{{$lang}}[description]" id="description" class="form-control" rows="6"></textarea>
                                </div>
                            </fieldset>
                        @endforeach

                        {{--
                        @if ($categories->count())
                            <div class="form-group">
                                <label for="category">Родительская категория</label>
                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">-----</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        --}}
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <single-uploader name="cover"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection