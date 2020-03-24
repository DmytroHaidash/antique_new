@extends('layouts.client', ['page_title' => $product->translate('title')])


@section('content')
    @if($page->hasMedia('cover'))
        <section class="lozad page-header" data-background-image="{{ $page->getFirstMediaUrl('cover') }}"></section>
    @endif
    <section class="{{$page->hasMedia('cover')? '-mt-32' : 'mt-32'}} mb-12">
        <div class="container">
            <h1 class="text-5xl font-thin leading-none text-center">{{ $product->translate('title') }}</h1>
            <div class="flex flex-wrap -mx-8 mt-12">
                <div class="w-1/2">
                    <a href="{{ $product->getBanner('uploads') }}">
                        <img data-src="{{ $product->getBanner('uploads') }}" class="lozad mb-4"
                             alt="{{ $product->translate('title') }}" data-fancybox="gallery"
                             data-background-image="{{ $product->getBanner() }}">
                    </a>
                    @if($product->hasMedia('uploads'))
                        <h6 class="mb-4">@lang('pages.product.all_photos')</h6>
                        <div class="flex flex-wrap">
                            @foreach($product->getMedia('uploads')->slice(1) as $photo)
                                <div class="w-1/3">
                                    <a href="{{ $photo->getUrl('banner') }}">
                                        <img data-fancybox="gallery" data-src="{{ $photo->getFullUrl() }}"
                                             class="lozad">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="w-1/2">
                    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end mb-4 ml-4">
                        <div>
                            <h4 class="price mt-4">
                                <small class="text-muted">@lang('pages.product.price'):</small>
                                {{ number_format($product->price, 0, ',', ' ') }}
                                @lang('common.currency')
                            </h4>
                        </div>

                        <div class="ml-sm-auto text-right">
                            @if ($product->in_stock)
                                <p class="text-success">@lang('pages.product.in_stock')</p>
                            @else
                                <p class="text-danger">@lang('pages.product.out_of_stock')</p>
                            @endif
                            <div class="ml-auto mt-4">
                                <button class="button button--primary modal-btn"
                                        data-modal-open="buyModal">
                                    @lang('pages.product.buy')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="ml-4">
                        <p class="lead">{{ $product->translate('description') }}</p>
                        {!! $product->body !!}

                        <div class="mt-4">
                            <button class="button button--primary-outline modal-button"
                                    data-modal-opened="question">
                                @lang('pages.product.question')
                            </button>
                        </div>
                        @if(Auth::user() && Auth::user()->hasRole('admin'))
                            <a href="{{route('client.catalog.pdf', $product)}}"  download class="button button--primary-outline h4 px-4 py-3 mb-0 ml-3">
                                Скачать PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($popular->count())
        <section>
            <div class="flex flex-wrap justify-center">
                <h5 class="mb-4">@lang('pages.product.popular')</h5>
            </div>
            <div class="exhibits grid">
                @foreach($popular as $item)
                    @include('partials.client.catalog.preview', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif

    @include('client.catalog.order-modal')
    @include('client.catalog.question-modal')

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endpush

@section('meta')
    @includeIf('partials.app.layout.meta', ['meta' => $product->meta()->first()])
    <meta property="og:type" content="product.item">
    <meta property="og:image"
          content="{{ $product->hasMedia('uploads') ? $product->getFirstMedia('uploads')->getFullUrl() : '' }}">
    <meta property="product:condition" content="new">
    <meta property="product:availability" content="{{$product->in_stock}}">
    <meta property="product:price:amount" content="{{ $product->price }}">
    <meta property="product:price:currency" content="грн">
@endsection

