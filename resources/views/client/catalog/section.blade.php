@extends('layouts.client', ['page_title' => $section->title])

@section('content')

    <section class="lozad page-header" data-background-image="{{ $section->getBanner() }}"></section>

    <section class="-mt-24 mb-12">
        <div class="container text-center">
            <h1 class="text-5xl leading-none font-heading title--decorated">
                <span class="title-decoration">{{ $section->title }}</span>
            </h1>
        </div>
    </section>

    <section class="my-12">
        <div class="exhibits {{ $exhibits->count() ? 'grid' : '' }}">
            @each('partials.client.catalog.teaser', $exhibits, 'exhibit', 'partials.client.layout.not-found')
        </div>
    </section>


@endsection
