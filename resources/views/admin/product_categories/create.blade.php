@extends('layouts.admin', ['page_title' => 'Создание категории'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.product_categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-9">
                    <block-editor title="Новая категория">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Название категории</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') }}" required>
                                    @if($errors->has($lang.'.title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.title') }}
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        @endforeach
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
                    </block-editor>
                </div>

                <div class="col-md-3">
                    <single-uploader name="cover"></single-uploader>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
