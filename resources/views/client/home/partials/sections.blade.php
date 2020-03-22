<section>
    @foreach($sections as $section)
        <h2 class="text-center text-3xl my-12 relative z-20 relative font-heading">
            <span>{{ $section->title }}</span>
            <div class="title-decoration inset-x-0 mx-auto w-40 h-16"></div>
        </h2>

        @if ($section->products->count())
            <div class="flex flex-wrap">
                @foreach($section->products as $child)
                    <article class="teaser section-teaser w-full lg:flex-1">
                        <figure class="lozad teaser__thumbnail"
                                data-background-image="{{ $child->getBanner() }}"></figure>

                        <a class="teaser__link p-6 lg:p-10"
                           href="{{ route('client.catalog.show', $child) }}">
                            <div class="teaser__title">
                                <h4 class="text-3xl title title--striped">
                                    <span>{{ $child->title }}</span>
                                </h4>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    @endforeach
</section>