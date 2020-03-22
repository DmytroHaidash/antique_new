@extends('layouts.admin', ['page_title' => 'Новый контакт'])

@section('content')

    <section>
        <form action="{{ route('admin.contacts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Новый контакт">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input id="name" type="text" name="{{$lang}}[name]"
                                           class="form-control{{ $errors->has($lang.'.name') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.name') }}">
                                    @if($errors->has('name'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="position">Должность</label>
                                    <input id="position" type="text" name="{{$lang}}[position]"
                                           class="form-control{{ $errors->has($lang.'.position') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.position') }}">
                                    @if($errors->has('position'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.position') }}
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        @endforeach

                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="email">Email</label>
                                <input type="email" name="contacts[email]" class="form-control" value="{{ old('contacts.email') }}">
                            </div>
                            <div class="col-6 form-group">
                                <label for="phone">Телефон</label>
                                <input type="tel" name="contacts[phone]" class="form-control" value="{{ old('contacts.phone') }}">
                            </div>
                        </div>
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