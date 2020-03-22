@extends('layouts.auth')

@section('content')

    <section class="my-12 w-full max-w-md">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <input id="email"
                       type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       autofocus
                       placeholder="{{ __('auth.email') }}">

                @error('email')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="{{ __('auth.password') }}">

                @error('password')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="flex items-center -mx-4 mb-4">
                <div class="px-4">
                    <button type="submit" class="button button--primary">
                        {{ __('auth.login') }}
                    </button>
                </div>
                <div class="px-4 whitespace-no-wrap flex">
                    <input class="form-checkbox text-purple-900" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember" class="ml-2">
                        {{ __('auth.remember') }}
                    </label>
                </div>
            </div>

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('auth.forgot') }}
                </a>
            @endif
        </form>
    </section>

@endsection
