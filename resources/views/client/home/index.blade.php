@extends('layouts.client', ['page_title' => __('nav.home')])

@section('content')

    @include('client.home.partials.slideshow')
    @include('client.home.partials.sections')

    @includeWhen($posts->count(), 'partials.client.blog.section')

@endsection

@section('meta')
@includeIf('partials.client.layout.meta', ['meta' => $banner->meta()->first()])

@endsection
