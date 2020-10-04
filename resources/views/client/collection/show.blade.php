@extends('layouts.client', ['page_title' => $exhibit->title])

@section('content')

    <section class="lozad page-header" data-background-image="{{ $exhibit->getBanner('uploads') }}"></section>

    <section class="-mt-24 mb-12">
        <div class="container">
            <h1 class="text-5xl font-thin leading-none text-center">{{ $exhibit->title }}</h1>

            @if ($exhibit->author_id)
                <h4 class="text-2xl mt-3 font-serif italic text-center">{{ $exhibit->author->name }}</h4>
            @endif

            <div class="flex flex-wrap -mx-8 mt-12">
                @foreach($props as $prop => $name)
                    <div class="px-8 w-1/2 md:w-1/3 lg:w-1/6 mb-4">
                        <p class="text-xs uppercase text-gray-500">{{ __('exhibits.props.'.$prop) }}</p>
                        <h4>{{ $name }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container text-center mb-12">
        @foreach($exhibit->getMedia('uploads') as $media)
            <p class="mb-8">
                <a data-fancybox="gallery" href="{{ $media->getFullUrl('banner') }}">
                    <img data-src="{{ $media->getFullUrl('banner') }}" class="lozad max-h-screen" alt="">
                </a>
            </p>
        @endforeach
    </section>

    <section class="page-content">
        @if ($exhibit->hasTranslation('body'))
            <div class="text-2xl font-serif italic max-w-3xl mx-auto mt-4 ml-3">
                {!! $exhibit->body !!}
            </div>
        @endif
    </section>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endpush

@section('meta')
    @includeIf('partials.client.layout.meta', ['meta' => $exhibit->meta()->first()])
@endsection