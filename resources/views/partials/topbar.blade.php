@php
$nav = [
  ['n' => '01', 'label' => 'CAPABILITIES', 'route' => 'capabilities.index'],
  ['n' => '02', 'label' => 'EVIDENCE',     'route' => 'home', 'fragment' => '#evidence'],
  ['n' => '03', 'label' => 'WORK',         'route' => 'work.index'],
  ['n' => '04', 'label' => 'BRIEFINGS',    'route' => 'briefings.index'],
  ['n' => '05', 'label' => 'FIRM',         'route' => 'firm'],
];
@endphp
<header class="topbar">
  <div class="wrap topbar-inner">
    <a href="{{ route('home') }}" class="brand" aria-label="Brownclaw Asset Management">
      <svg class="mark" viewBox="0 0 64 64" aria-hidden="true">
        <g fill="#F2A82A">
          <path d="M9 18 q3 -11 9 -12 q1 5 -2 13 z"/>
          <path d="M21 12 q4 -10 10 -8 q1 5 -3 11 z"/>
          <path d="M33 12 q4 -10 10 -8 q1 5 -3 11 z"/>
          <path d="M45 14 q5 -8 10 -5 q0 5 -5 10 z"/>
          <ellipse cx="14" cy="29" rx="6" ry="9"/>
          <ellipse cx="26" cy="27" rx="6.5" ry="10"/>
          <ellipse cx="38" cy="27" rx="6.5" ry="10"/>
          <ellipse cx="50" cy="29" rx="6" ry="9"/>
          <path d="M14 44 q12 -8 22 0 q9 6 14 0 v9 q-6 4 -14 4 q-9 0 -22 -2 z"/>
          <path d="M22 51 l5 -7 l5 7 l4 -5 l5 5 z" fill="#0D1014"/>
        </g>
      </svg>
      <div class="word">
        <span class="a">BROWNCLAW</span>
        <span class="b">Asset Management · P.Eng · CMRP</span>
      </div>
    </a>

    <nav class="nav" aria-label="Primary">
      @foreach($nav as $item)
        <a class="item" href="{{ route($item['route']) . ($item['fragment'] ?? '') }}">
          <span class="num">{{ $item['n'] }}</span>{{ $item['label'] }}
        </a>
      @endforeach
      <a class="cta" href="{{ route('contact') }}">
        REQUEST ENGAGEMENT
        <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </nav>
  </div>
</header>
