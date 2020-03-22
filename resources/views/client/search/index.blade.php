@extends('layouts.client', ['page_title' => __('common.header.search')])

@section('content')

    <section class="mt-32 mb-12 container text-center">
        <h1 class="text-5xl font-thin leading-none text-center font-heading">
            <span>{{ __('common.header.search') }}: &laquo;{{ $query }}&raquo;</span>
        </h1>
    </section>

    <section class="my-12">
        <div class="exhibits {{ $exhibits->count() ? 'grid' : '' }}">
            @each('partials.client.exhibits.teaser', $exhibits, 'exhibit', 'partials.client.layout.not-found')
        </div>

        @if ($exhibits->total() > 1)
            <div class="container mt-10">
                {{ $exhibits->links() }}
            </div>
        @endif
    </section>

@endsection