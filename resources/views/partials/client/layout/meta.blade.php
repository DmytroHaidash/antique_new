@if($meta)
    @if($meta->title)
    <meta name="title" content="{{ $meta->title }}">
    <meta property="og:title" content="{{ $meta->title }}">
    @endif
    @if ($meta->description)
        <meta name="description" content="{{ $meta->description }}">
        <meta property="og:description" content="{{ $meta->description }}">
    @endif
    @if ($meta->keywords)
        <meta name="keywords" content="{{ $meta->keywords }}">
    @endif
@endif