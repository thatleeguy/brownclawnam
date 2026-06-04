@php
  $navItems = $settings->navItems();
@endphp
<header class="topbar">
  <div class="wrap topbar-inner">
    <a href="{{ route('home') }}" class="brand" aria-label="{{ $settings->brand_name ?: 'Brownclaw Asset Management' }}">
      <img src="{{ asset($settings->logo_path ?: 'img/logo-side.png') }}" class="brand-logo" alt="{{ $settings->brand_name ?: 'Brownclaw Asset Management' }}" />
    </a>

    <nav class="nav" aria-label="Primary">
      @foreach($navItems as $item)
        <a class="item" href="{{ $item['url'] ?? '#' }}">
          <span class="num">{{ $item['number'] ?? '' }}</span>{{ $item['label'] ?? '' }}
        </a>
      @endforeach
      <a class="cta" href="{{ $settings->nav_cta_url ?: route('contact') }}">
        {{ $settings->nav_cta_label ?: 'REQUEST ENGAGEMENT' }}
        <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </nav>
  </div>
</header>
