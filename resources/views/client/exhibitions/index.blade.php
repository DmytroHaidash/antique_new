@extends('layouts.client', ['page_title' => __('nav.exhibitions')])

@section('content')

    <section class="mt-32 mb-12 container text-center">
        <h1 class="text-5xl font-thin leading-none mb-12 font-heading">
            <span>{{ __('nav.exhibitions') }}</span>
        </h1>

        @includeWhen($years->count(), 'partials.client.exhibitions.filter')
    </section>

    <section class="my-12">
        <div class="flex flex-wrap justify-center">
            @each('partials.client.exhibitions.teaser', $exhibitions, 'exhibition', 'partials.client.layout.not-found')
        </div>
    </section>

@endsection