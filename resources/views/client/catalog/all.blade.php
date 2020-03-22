@extends('layouts.client', ['page_title' => $page->translate('title')])

@section('content')
    @if($page->hasMedia('cover'))
        <section class="lozad page-header" data-background-image="{{ $page->getFirstMediaUrl('cover') }}"></section>
    @endif
    <section class="{{$page->hasMedia('cover')? '-mt-32' : 'mt-32'}} mb-12 container">
        <h1 class="text-5xl font-thin leading-none text-center font-heading">
            <span>{{ $page->title }}</span>
        </h1>
        <div class="page-content mt-8">
            {!! $page->body !!}
        </div>
        <div class="mt-32 mb-12">
            <div class="container mx-0">
                @include('partials.client.catalog.search')
                @include('partials.client.catalog.filters')
                <div class="flex flex-wrap justify-center mt-6">
                    @each('partials.client.catalog.preview', $products, 'product', 'partials.client.layout.not-found')
                </div>
            </div>
        </div>
    </section>

@endsection

@section('meta')
    <meta property="og:type" content="product.group">
    @includeIf('partials.app.layout.meta', ['meta' => $page->meta()->first()])
    @foreach($products as $product)
        @includeIf('partials.app.layout.meta', ['meta' => $product->meta()->first()])
    @endforeach
@endsection