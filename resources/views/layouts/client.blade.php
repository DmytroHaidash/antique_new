<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! config('app.name', 'Impression Admin') . (isset($page_title) ? ' | ' . $page_title : '') !!}</title>

    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
    @stack('styles')
</head>
<body>
@include('partials.client.layout.icons')

<div id="app" class="flex flex-col min-h-screen">
    @includeIf('partials.client.layout.header')
    @includeIf('partials.client.layout.mesengers')
    <main class="flex-1">

        @yield('content')
    </main>
    @includeIf('partials.client.layout.footer')
</div>

<script src="{{ asset('js/client.js') }}"></script>
@stack('scripts')
</body>
</html>
