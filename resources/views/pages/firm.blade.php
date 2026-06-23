@extends('layouts.site')
@section('title', 'Firm — Brownclaw Asset Management')
@section('description', $firm->meta_description ?: 'Brownclaw Asset Management — nine years in mining and energy reliability across coal, diamond, gold, copper, and zinc.')

@section('content')
<section class="hero" style="padding-bottom:0">
  <div class="wrap">
    <span class="eyebrow reveal">{{ $firm->hero_eyebrow ?: 'THE FIRM' }}</span>
    <h1 class="reveal d1" style="margin-top:18px">{!! $firm->hero_headline_html ?: 'A small firm. <span class="am">Tier-1 work.</span>' !!}</h1>
    <p class="hero-sub reveal d2">{{ $firm->hero_sub }}</p>
  </div>
</section>

@include('partials.principal')

<section style="padding: 0 0 clamp(80px, 9vw, 128px);">
  <div class="wrap" style="max-width: 920px;">
    <div class="reveal">
      <h2 class="disp-l">{{ $firm->engagement_heading ?: 'How an engagement runs' }}</h2>
      <ol style="list-style:none; padding:0; margin: 36px 0 0; display:flex; flex-direction:column; gap: 0;">
        @foreach(($firm->engagement_steps ?? []) as $step)
          <li class="reveal" style="display:grid; grid-template-columns: 80px 1fr; gap: 24px; padding: 24px 0; border-bottom: 1px solid var(--rule-1);">
            <div class="cond" style="color: var(--amber); font-size: 22px;">{{ $step['number'] ?? '' }}</div>
            <div>
              <h3 style="font-family:var(--display);font-weight:700;font-size:20px;letter-spacing:-0.014em;">{{ $step['title'] ?? '' }}</h3>
              <p style="color: var(--txt-2); margin-top: 8px; max-width: 60ch; line-height:1.6;">{{ $step['body'] ?? '' }}</p>
            </div>
          </li>
        @endforeach
      </ol>
    </div>
  </div>
</section>

@include('partials.contact-cta')
@endsection
