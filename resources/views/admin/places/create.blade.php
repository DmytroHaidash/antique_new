@extends('layouts.admin', ['page_title' => 'Новое место проведения'])

@section('content')

    <section>
        <form action="{{ route('admin.places.store') }}" method="post">
            @csrf

            <block-editor title="Новое место проведения">
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
                            <wysiwyg label="Описание" name="{{$lang}}[body]" content="{{old($lang.'.body')}}"
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