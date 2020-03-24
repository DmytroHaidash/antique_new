<article class="exhibit-teaser grid-item px-2">
    <a class="grid-item__content block" href="{{ route('client.catalog.index', ['category'=> $exhibit->slug]) }}">
        <img src="{{ $exhibit->getBanner('cover') }}" alt="">

        <div class="p-6 lg:p-10">
            <div class="teaser__title">
                <h4 class="text-2xl title title--striped">
                    <span>{{ $exhibit->title }}</span>
                </h4>
            </div>
        </div>
    </a>
</article>