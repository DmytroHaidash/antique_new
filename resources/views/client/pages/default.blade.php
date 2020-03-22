@extends('layouts.client', ['page_title' => $page->title])

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
        @if($page->slug == 'expertise')
            <div class="text-center mt-8">
                <button class="button button--primary modal-btn " data-modal-open="question">
                    @lang('pages.question.btn')
                </button>
            </div>
            @include('client.pages.question-modal')
        @endif
        @if($page->slug =='book')
            <div class="text-center mt-8">
                <button class="button button--primary modal-btn " data-modal-open="book-buy">
                    @lang('pages.book.btn')
                </button>
            </div>
            @include('client.pages.buy-modal')
        @endif
    </section>

@endsection
@section('meta')
    @includeIf('partials.app.layout.meta', ['meta' => $page->meta()->first()])
@endsection