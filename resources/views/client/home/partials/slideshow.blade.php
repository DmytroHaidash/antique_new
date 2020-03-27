<section class="slideshow hidden lg:block">
    <div class="slides slides--images">
        <div class="slide slide--current">
            <figure class="slide__img"
                    style="background-image: url({{ $banner->hasMedia('cover')?
                    $banner->getFirstMediaUrl('cover'):asset('images/background.jpg') }})"></figure>
            {{--<div class="slide__title">
                <svg fill="#fff" class="slide__title-logo">
                    <use xlink:href="#logo"></use>
                </svg>
            </div>--}}
            <div class="slide__desc" hidden></div>
            <div class="slide__link mt-6">
                <a href="{{ url('/about')}}" class="button button--primary">
                    {{ __('nav.about') }}
                </a>
            </div>
        </div>
        @foreach($sections as $section)
            @if($section->hasMedia('cover'))
            <div class="slide slide--current">
                <figure class="slide__img"
                        style="background-image: url({{ optional($section->getFirstMedia('cover'))->getFullUrl('banner') }});">
                </figure>

                <h2 class="slide__title font-heading">{{ $section->title }}</h2>
                <div class="slide__link mt-6">
                    <a href="{{ route('client.catalog.index', ['category=' . $section->slug]) }}" class="button button--primary">
                        {{ __('pages.product.catalog') }}
                    </a>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <nav class="slidenav text-white">
        <button class="slidenav__item slidenav__item--prev mr-3">
            <svg width="12" height="18">
                <use xlink:href="#arow-icon"></use>
            </svg>
        </button>
        <button class="slidenav__item slidenav__item--next">
            <svg width="12" height="18">
                <use xlink:href="#arow-icon"></use>
            </svg>
        </button>
    </nav>
</section>
<div class="mobile-top" style="background-image: url({{ $banner->hasMedia('cover')?
                    $banner->getFirstMediaUrl('cover'):asset('images/background.jpg') }})">
    <svg fill="#fff" class="mobile-top__logo">
        <use xlink:href="#logo"></use>
    </svg>
</div>
