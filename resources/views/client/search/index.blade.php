@extends('layouts.client', ['page_title' => __('common.header.search')])

@section('content')

    <section class="mt-32 mb-12 container text-center">
        <h1 class="text-5xl font-thin leading-none text-center font-heading">
            <span>{{ __('common.header.search') }}: &laquo;{{ $query }}&raquo;</span>
        </h1>
    </section>

    <section class="my-12">
        <div class="mt-12 mb-12">
            <div class="container mx-0">
                <div class="flex flex-wrap justify-center mt-6">
                    @each('partials.client.catalog.prev', $products, 'product', 'partials.client.layout.not-found')
                </div>

                @if ($products->total() > 1)
                    <div class="container mt-10">
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>
        </div>

    </section>

@endsection
