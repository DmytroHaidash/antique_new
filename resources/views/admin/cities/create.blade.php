@extends('layouts.admin', ['page_title' => 'Новый город'])

@section('content')

    <section>
        <form action="{{ route('admin.cities.store') }}" method="post">
            @csrf

            <block-editor title="Новый город">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group">
                            <label for="name">Название города</label>
                            <input id="name" type="text" name="{{$lang}}[name]"
                                   class="form-control{{ $errors->has($lang.'.name') ? ' is-invalid' : '' }}"
                                   value="{{ old($lang.'.name') }}">
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