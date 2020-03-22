<article class="teaser post-teaser w-1/2 lg:w-1/3">
    <figure class="lozad teaser__thumbnail"
            data-background-image="{{ $blogPost->getBanner() }}"></figure>

    <a class="teaser__link p-6 lg:p-10" href="{{ route('client.blog.show', $blogPost) }}">
        <div class="teaser__title">
            <div class="text-xs">{{ mb_strtolower($blogPost->created_at->formatLocalized('%d %B %Y')) }}</div>
            <h4 class="text-xl title title--filled">
                <span>{{ $blogPost->title }}</span>
            </h4>
        </div>

        @if ($blogPost->hasTranslation('description'))
            <div class="teaser__description mt-3 px-6 lg:px-10">
                {{ Str::limit($blogPost->description, 150) }}
            </div>
        @endif
    </a>
</article>