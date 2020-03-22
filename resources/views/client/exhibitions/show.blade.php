@extends('layouts.client', ['page_title' => $exhibition->title])

@section('content')

    <section class="lozad page-header" data-background-image="{{ $exhibition->getBanner('uploads') }}"></section>

    <section class="-mt-24 mb-12">
        <div class="container">
            <h1 class="text-5xl font-thin leading-none text-center">{{ $exhibition->title }}</h1>

            <div class="page-content">
                <div class="flex flex-wrap justify-center -mx-8 mt-12 mb-8">
                    <div class="px-8">
                        <p class="text-xs uppercase text-gray-500">{{ __('pages.exhibitions.date') }}</p>
                        <h4>
                            {{ optional($exhibition->city)->name . (($exhibition->place_id ? ', ' : '') . $exhibition->place->title) }}
                        </h4>
                    </div>

                    <div class="px-8">
                        <p class="text-xs uppercase text-gray-500">{{ __('pages.exhibitions.place') }}</p>
                        <h4>
                            {{ $exhibition->starts_at->format('d.m.Y') }}
                            @if ($exhibition->ends_at)
                            &mdash;
                            {{ $exhibition->ends_at->format('d.m.Y') }}
                        </h4>
                        @endif
                    </div>
                </div>

                {!! $exhibition->body !!}
            </div>
        </div>
    </section>

@endsection