{{--<article class="teaser post-teaser w-1/2 lg:w-1/3">
    <figure class="lozad teaser__thumbnail"
            data-background-image="{{ $product->getBanner('uploads') }}"></figure>

        <a class="teaser__link p-6 lg:p-10" href="{{ route('client.catalog.show', $product) }}">
        <div class="teaser__link p-6 lg:p-10">
            <div class="teaser__title">
                <h4 class="text-2xl title title--striped">
                    <span>{{ $product->title }}</span>
                </h4>
                @if ($product->hasTranslation('description'))
                    <div class="mt-3 font-serif italic">{{ str_limit($product->translate('description'), 50) }}</div>
                @endif
            </div>

            <div class="flex -mx-2 mt-3 font-sm">
                <div class="px-2 w-1/3">{{ $product->price }} @lang('common.currency')</div>
            </div>
        </div>
    </a>
</article>--}}

<article class="exhibit-teaser grid-item px-2">
    <a class="grid-item__content block" href="{{ route('client.catalog.show', $product) }}">
        <img src="{{ $product->getBanner('uploads') }}" alt="">

        <div class="p-6 lg:p-10">
            <div class="teaser__title">
                <h4 class="text-2xl title title--striped">
                    <span>{{ $product->title }}</span>
                </h4>
                @if($product->publish_price && $product->in_stock == 'stock')
                    <div class="flex -mx-2 mt-3 font-sm">
                        <div class="px-2 w-1/3">{{ $product->price }} @lang('common.currency')</div>
                    </div>
                @endif
                @if ($product->in_stock == 'sold')
                    <p class="text-success">@lang('pages.product.sold')</p>
                @elseif($product->in_stock == 'reserved')
                    <p class="text-danger">@lang('pages.product.reserved')</p>
                @endif
            </div>
        </div>
    </a>
</article>
