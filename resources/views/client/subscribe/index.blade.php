@extends('layouts.client', ['page_title' => __('forms.buttons.subscribe')])

@section('content')
    <section class="mt-32 mb-12 container">
        <h5 class="text-2xl text-center mb-5">@lang('forms.buttons.subscribe') </h5>
        <form action="{{route('client.subscribe')}}" method="post">
            @csrf

            <div class="mb-5">
                <label for="subscribe_first_name"
                       class="block font-bold uppercase text-xs mb-2">@lang('forms.first_name')</label>
                <input type="text" class="form-control @error('subscribe_first_name') border-red @enderror"
                       id="subscribe_first_name" name="subscribe_first_name"
                       value="{{ old('subscribe_first_name') }}" required>
                @error('subscribe_first_name')
                <div class="text-red" role="alert">
                    <strong>{{ $errors->first('subscribe_first_name') }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-5">
                <label for="subscribe_last_name"
                       class="block font-bold uppercase text-xs mb-2">@lang('forms.last_name')</label>
                <input type="text" class="form-control @error('subscribe_last_name') border-red @enderror"
                       id="subscribe_last_name" name="subscribe_last_name"
                       value="{{ old('subscribe_last_name') }}" required>
                @error('subscribe_last_name')
                <div class="text-red" role="alert">
                    <strong>{{ $errors->first('subscribe_last_name') }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-5">
                <label for="subscribe_phone" class="block font-bold uppercase text-xs mb-2">@lang('forms.phone')</label>
                <input type="tel" class="form-control @error('subscribe_phone') border-red @enderror" id="phone"
                       name="subscribe_phone"
                       value="{{ old('subscribe_phone') }}">
                @error('subscribe_phone')
                <div class="text-red" role="alert">
                    <strong>{{ $errors->first('subscribe_phone') }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-5">
                <label for="subscribe_email" class="block font-bold uppercase text-xs mb-2">@lang('forms.email')</label>
                <input type="email" class="form-control @error('subscribe_email') border-red @enderror"
                       id="subscribe_email"
                       name="subscribe_email"
                       value="{{ old('subscribe_email') }}">
                @error('subscribe_email')
                <div class="text-red" role="alert">
                    <strong>{{ $errors->first('subscribe_email') }}</strong>
                </div>
                @enderror
            </div>
            <button class="button button--primary">@lang('forms.buttons.subscribe')</button>
        </form>
    </section>
@endsection
