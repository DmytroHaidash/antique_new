@extends('layouts.admin', ['page_title' => 'Редактировать контакт'])

@section('content')

    <section>
        <form action="{{ route('admin.contacts.update', $contact) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <block-editor title="Редактировать контакт">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input id="name" type="text" name="{{$lang}}[name]"
                                           class="form-control{{ $errors->has($lang.'.name') ? ' is-invalid' : '' }}"
                                           value="{{ old($lang.'.name') ?? $contact->getTranslation('name', $lang) }}">
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
                                           value="{{ old($lang.'.position') ?? $contact->getTranslation('position', $lang) }}">
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
                                <input type="email" name="contacts[email]" class="form-control"
                                       value="{{ old('contacts.email') ?? $contact->contacts['email'] }}">
                            </div>
                            <div class="col-6 form-group">
                                <label for="phone">Телефон</label>
                                <input type="tel" name="contacts[phone]" class="form-control"
                                       value="{{ old('contacts.phone') ?? $contact->contacts['phone'] }}">
                            </div>
                        </div>
                    </block-editor>
                </div>

                <div class="col-lg-4">
                    <single-uploader name="cover" src="{{ optional($contact->getFirstMedia('cover'))->getFullUrl('cover') }}"></single-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection