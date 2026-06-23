<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>@yield('title', $settings->default_meta_title ?: 'Brownclaw Asset Management — Reliability Engineering for Heavy Industry')</title>
<meta name="description" content="@yield('description', $settings->default_meta_description ?: 'A reliability and asset-management practice for mining and energy operators.')" />

<link rel="icon" type="image/png" href="{{ asset($settings->favicon_path ?: 'favicon.png') }}?v=claw2" />
<link rel="apple-touch-icon" href="{{ asset($settings->favicon_path ?: 'favicon.png') }}?v=claw2" />

<meta property="og:title" content="@yield('title', $settings->default_meta_title ?: 'Brownclaw Asset Management')" />
<meta property="og:description" content="@yield('description', $settings->default_meta_description ?: 'Reliability and asset-management for mining and energy operators.')" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta name="twitter:card" content="summary_large_image" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@300;400;500;600;700&family=IBM+Plex+Sans+Condensed:wght@500;600;700&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('partials.theme')
@stack('head')
</head>
<body>

@if($settings->statusbar_visible)
  @include('partials.statusbar')
@endif
@include('partials.topbar')

@yield('content')

@include('partials.footer')

@stack('scripts')
</body>
</html>
