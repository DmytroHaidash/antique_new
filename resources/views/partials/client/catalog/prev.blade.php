<article class="teaser post-teaser w-1/2 lg:w-1/3">
    <figure class="lozad teaser__thumbnail"
            data-background-image="{{ $product->getBanner('uploads') }}"></figure>

    <a class="teaser__link p-2" href="{{ route('client.catalog.show', $product) }}">
        <div class="teaser__title">
            <h4 class="text-xl title title--striped">
                <span>{{ $product->title }} </span>
            </h4>
        </div>

        @if($product->publish_price)
            <div class="flex -mx-2 font-sm">
                <div class="px-2 w-1/3 text-sm">{{ $product->price }} @lang('common.currency')</div>
            </div>
        @endif
    </a>
</article>
