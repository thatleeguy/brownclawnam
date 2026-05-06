@extends('layouts.site')
@section('title', $insight->title . ' — Brownclaw Asset Management')
@section('description', \Illuminate\Support\Str::limit(strip_tags($insight->excerpt), 160))

@push('head')
<style>
.body-prose{ max-width: 68ch; margin: 0 auto; color: var(--txt-2); font-size: 17px; line-height: 1.72; }
.body-prose h2{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: clamp(26px, 2.6vw, 36px); letter-spacing: -0.022em; margin: 56px 0 16px; line-height: 1.08; }
.body-prose h3{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: 22px; letter-spacing: -0.014em; margin: 38px 0 12px; }
.body-prose p, .body-prose ul, .body-prose ol{ margin: 0 0 1.1em; }
.body-prose ul, .body-prose ol{ padding-left: 1.4em; }
.body-prose li{ margin-bottom: 0.45em; }
.body-prose strong{ color: var(--txt); font-weight: 600; }
.body-prose blockquote{ border-left: 3px solid var(--amber); padding: 14px 22px; margin: 28px 0; background: var(--steel-2); color: var(--txt); }
.body-prose code{ font-family: var(--mono); font-size: 0.92em; background: var(--steel-2); padding: 2px 6px; border: 1px solid var(--rule-1); }
.body-prose pre{ background: var(--steel-2); border:1px solid var(--rule-2); padding: 18px; overflow:auto; margin: 24px 0; }
.body-prose pre code{ border:0; padding:0; background:transparent; }
.body-prose a{ color: var(--amber); text-decoration: underline; text-underline-offset: 3px; }
.body-prose hr{ border: 0; border-top: 1px solid var(--rule-1); margin: 48px 0; }
</style>
@endpush

@section('content')
<section class="hero" style="padding-bottom: clamp(60px, 7vw, 100px);">
  <div class="wrap">
    <a href="{{ route('briefings.index') }}" style="display:inline-flex;gap:8px;align-items:center;font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);margin-bottom:24px;">
      ← All briefings
    </a>
    <span class="eyebrow reveal">{{ $insight->code ?? 'BRIEF' }} · {{ strtoupper($insight->kicker ?? 'BRIEFING') }} @if($insight->published_at)· {{ $insight->published_at->format('d M Y') }}@endif @if($insight->reading_minutes)· {{ $insight->reading_minutes }} MIN @endif</span>
    <h1 class="reveal d1" style="margin-top:18px;max-width: 22ch;">{{ $insight->title }}</h1>
    @if($insight->excerpt)
      <p class="hero-sub reveal d2" style="font-style:italic;">{{ $insight->excerpt }}</p>
    @endif
  </div>
</section>

<section style="padding: 0 0 clamp(80px, 9vw, 128px);">
  <div class="wrap reveal">
    <div class="body-prose">
      {!! \App\Support\Markdown::render($insight->body) !!}
    </div>
  </div>
</section>

@if($more->count())
  <section class="briefings">
    <div class="wrap">
      <div class="section-head reveal">
        <h2 class="disp-l">More briefings</h2>
        <div class="right" style="text-align:right">
          <a href="{{ route('briefings.index') }}" style="color:var(--amber);font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;">Archive →</a>
        </div>
      </div>
      <div class="brief-grid">
        @foreach($more as $i => $b)
          <article class="brief reveal d{{ $i + 1 }}">
            <div class="id">
              <span class="am">{{ $b->code ?? 'BRIEF' }}</span>
              <span><b>{{ strtoupper($b->kicker ?? '') }}</b> · {{ optional($b->published_at)->format('d M y') }}</span>
            </div>
            <h3>{{ $b->title }}</h3>
            <p class="excerpt">{{ \Illuminate\Support\Str::limit($b->excerpt, 140) }}</p>
            <a href="{{ route('briefings.show', $b) }}" class="read">
              Read
              <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

@include('partials.contact-cta')
@endsection
