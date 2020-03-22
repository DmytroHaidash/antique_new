<article class="teaser exhibition-teaser w-full md:w-1/2 lg:w-1/3">
    <figure class="lozad teaser__thumbnail"
            data-background-image="{{ $exhibition->getBanner('cover') }}"></figure>

    <a class="teaser__link p-6 lg:p-10" href="{{ route('client.exhibitions.show', $exhibition) }}">
        <div class="teaser__title">
            <h4 class="text-2xl title title--striped">
                <span>{{ $exhibition->title }}</span>
            </h4>
            <p>{{ optional($exhibition->city)->name . (($exhibition->place_id ? ', ' : '') . $exhibition->place->title) }}</p>
            <p>
                {{ $exhibition->starts_at->format('d.m.Y') }}
                @if ($exhibition->ends_at)
                &mdash;
                {{ $exhibition->ends_at->format('d.m.Y') }}
                @endif
            </p>
        </div>

        @if ($exhibition->hasTranslation('description'))
            <div class="teaser__description mt-3 px-6 lg:px-10">
                {{ $exhibition->description }}
            </div>
        @endif
    </a>
</article>