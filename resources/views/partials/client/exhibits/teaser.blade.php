<article class="exhibit-teaser grid-item px-2">
    <a class="grid-item__content block" href="{{ route('client.collection.show', $exhibit) }}">
        <img src="{{ $exhibit->getBanner('uploads') }}" alt="">

        <div class="p-6 lg:p-10">
            <div class="teaser__title">
                <h4 class="text-2xl title title--striped">
                    <span>{{ $exhibit->title }}</span>
                </h4>
                @if ($exhibit->author_id)
                    <div class="mt-3 font-serif italic">{{ $exhibit->author->name }}</div>
                @endif
            </div>

            <div class="flex -mx-2 mt-3 font-sm">
                <div class="px-2 w-1/3">{{ $exhibit->props['number'] }}</div>
                <div class="px-2 w-1/3">{{ $exhibit->props['origin'] }}</div>
                <div class="px-2 w-1/3">{{ $exhibit->props['time'] }}</div>
            </div>
        </div>
    </a>
</article>