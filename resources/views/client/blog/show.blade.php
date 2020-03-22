@extends('layouts.client', ['page_title' => $post->title])

@section('content')

    <section class="lozad page-header" data-background-image="{{ $post->getBanner() }}"></section>

    <section class="-mt-24 mb-12 container">
        <h1 class="text-5xl font-thin leading-none text-center">{{ $post->title }}</h1>
        @if($post->video)
            <div class="flex flex-wrap -mx-8 mt-12 justify-center">
                <div class="w-full mb-4  mt-4">
                    <div class="video-feedback" data-youtube="{{$post->video}}"></div>
                </div>
            </div>
        @endif
        <div class="page-content mt-8">
            <div class="flex items-center mb-8 font-serif italic text-xl">
                <time datetime="{{ $post->created_at }}">{{ mb_strtolower($post->created_at->formatLocalized('%d %B %Y')) }}</time>
                <hr class="border-b border-green-500 ml-4 my-0 flex-grow opacity-25">
            </div>

            <div class="text-xl border-l border-yellow-500 mb-8 pl-4">
                {{ $post->description }}
            </div>

            {!! $post->body !!}
        </div>
    </section>

@endsection

@section('meta')
    @includeIf('partials.app.layout.meta', ['meta' => $post->meta()->first()])
@endsection