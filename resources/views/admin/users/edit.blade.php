@extends('layouts.admin', ['page_title' => 'Редактирование пользователя'])

@section('content')

    <section>
        <form action="{{ route('admin.users.update', $user) }}" method="post">
            @csrf
            @method('patch')

            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="form-group">
                <label for="title">Имя</label>
                <input id="title" type="text" name="name"
                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       value="{{ old('name') ?? $user->name }}" required>

                @if($errors->has('name'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="role">Роль</label>

                <input type="hidden" name="role" value="{{ $user->role }}">
                <select name="role" id="role" class="form-control"
                    {{ $user->id == Auth::user()->id ? 'disabled' : '' }}>
                    @foreach(\App\Models\User::$roles as $role)
                        <option value="{{ $role }}"
                            {{ $role === $user->role ? 'selected' : '' }}>
                            {{ __('admin.roles.'.strtolower($role)) }}
                        </option>
                    @endforeach
                </select>

                @if($errors->has('role'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('role') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email"
                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       value="{{ old('email') ?? $user->email }}" autocomplete="none" required>

                @if($errors->has('email'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <password-change inline-template>
                <div class="passwords">
                    <div class="custom-control custom-checkbox mt-4 mb-2">
                        <input type="checkbox" class="custom-control-input" id="show_passwords" @change="toggle">
                        <label class="custom-control-label" for="show_passwords">Изменить пороль</label>
                    </div>

                    <fieldset v-if="visible">
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input id="password" type="password" name="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   autocomplete="none" required>
                            @if($errors->has('password'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Повторите пароль</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   autocomplete="none" required>
                        </div>
                    </fieldset>
                </div>
            </password-change>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
