<div class="custom-modal-3" id="askPrice">

    <div class="custom-modal-3--close">
        <svg width="24" height="24" class="fill-current">
            <use xlink:href="#close"></use>
        </svg>
    </div>

    <h5 class="text-2xl text-center mb-5">@lang('pages.product.ask_price') {{ $product->title }}</h5>
    <form action="{{ route('client.catalog.price', $product) }}" method="post">
        @csrf
        <div class="mb-5">
            <label for="email" class="block font-bold uppercase text-xs mb-2">@lang('forms.ask_email')</label>
            <input type="email" class="form-control @error('email') border-red @enderror" id="email" name="email"
                   value="{{ old('email') }}" required>
            @error('contact')
            <div class="text-red" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </div>
            @enderror
        </div>

        <button class="button button--primary">@lang('forms.buttons.ask-prise')</button>
    </form>
</div>

<div class="custom-modal-3-mask"></div>