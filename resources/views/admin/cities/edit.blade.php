@extends('layouts.admin', ['page_title' => 'Редактирование города'])

@section('content')

    <section>
        <form action="{{ route('admin.cities.update', $city) }}" method="post">
            @csrf
            @method('patch')

            <block-editor title="Редактирование города">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group">
                            <label for="name">Название города</label>
                            <input id="name" type="text" name="{{$lang}}[name]"
                                   class="form-control{{ $errors->has($lang.'.name') ? ' is-invalid' : '' }}"
                                   value="{{ old($lang.'.name') ?? $city->getTranslation('name', $lang) }}">
                            @if($errors->has('name'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first($lang.'.name') }}
                                </div>
                            @endif
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