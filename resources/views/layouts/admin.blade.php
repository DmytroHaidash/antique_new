<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="locales" content="{{ json_encode(config('app.locales')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Impression Admin') . (isset($page_title) ? ' | ' . $page_title : '') }}</title>

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div id="app">
    @includeIf('partials.admin.icons')
    @includeIf('partials.admin.header')
    @includeIf('partials.admin.aside')

    <main>
        <div class="container p-0 m-0">
            @yield('content')
        </div>
    </main>
</div>

<script src="{{ asset('js/admin.js') }}" defer></script>
@stack('scripts')
</body>
</html>
