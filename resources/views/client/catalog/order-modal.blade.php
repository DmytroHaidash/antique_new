<div class="custom-modal" id="buyModal">
    <div class="custom-modal--close">
        <svg width="24" height="24" class="fill-current">
            <use xlink:href="#close"></use>
        </svg>
    </div>

    <h5 class="text-2xl text-center mb-5">{{$product->translate('title')}} </h5>
    <form action="{{ route('client.catalog.buy', $product)}}" method="post">
        @csrf

        <div class="mb-5">
            <label for="name" class="block font-bold uppercase text-xs mb-2">@lang('pages.book.name')</label>
            <input type="text" class="form-control @error('name') border-red @enderror" id="name" name="name"
                   value="{{ old('name') }}" required>
            @error('name')
            <div class="text-red" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="phone" class="block font-bold uppercase text-xs mb-2">@lang('forms.phone')</label>
            <input type="tel" class="form-control @error('phone') border-red @enderror" id="phone" name="contact[phone]"
                   value="{{ old('phone') }}" required>
            @error('contact')
            <div class="text-red" role="alert">
                <strong>{{ $errors->first('phone') }}</strong>
            </div>
            @enderror
        </div>
        <div class="mb-5">
            <label for="email" class="block font-bold uppercase text-xs mb-2">@lang('forms.email')</label>
            <input type="email" class="form-control @error('email') border-red @enderror" id="email" name="contact[email]"
                   value="{{ old('email') }}" required>
            @error('contact')
            <div class="text-red" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </div>
            @enderror
        </div>
        <div class="mb-5">
            <label for="message" class="block font-bold uppercase text-xs mb-2">@lang('forms.message.order')</label>
            <textarea class="form-control border" id="message"
                      name="message">{{ old('message') }}</textarea>
        </div>

        <button class="button button--primary">@lang('forms.buttons.buy')</button>
    </form>
</div>
<div class="custom-modal-mask"></div>