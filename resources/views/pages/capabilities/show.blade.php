@extends('layouts.site')
@section('title', $capability->title . ' — Brownclaw Asset Management')
@section('description', \Illuminate\Support\Str::limit(strip_tags($capability->summary), 160))

@push('head')
<style>
.body-prose{ max-width: 70ch; color: var(--txt-2); font-size: var(--fs-body); line-height: 1.7; }
.body-prose h2{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: clamp(24px, 2.4vw, 34px); letter-spacing: -0.02em; margin: 56px 0 16px; line-height: 1.1; }
.body-prose h3{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: 20px; letter-spacing: -0.014em; margin: 36px 0 10px; }
.body-prose p, .body-prose ul, .body-prose ol{ margin: 0 0 1.05em; }
.body-prose ul, .body-prose ol{ padding-left: 1.4em; }
.body-prose li{ margin-bottom: 0.4em; }
.body-prose strong{ color: var(--txt); font-weight: 600; }
.body-prose blockquote{ border-left: 3px solid var(--amber); padding: 12px 18px; margin: 24px 0; background: var(--steel-2); font-style: normal; color: var(--txt); }
.body-prose code{ font-family: var(--mono); font-size: 0.92em; background: var(--steel-2); padding: 2px 6px; border: 1px solid var(--rule-1); }
.body-prose a{ color: var(--amber); text-decoration: underline; text-underline-offset: 3px; }
</style>
@endpush

@section('content')
<section class="hero" style="padding-bottom: clamp(60px, 7vw, 100px);">
  <div class="wrap">
    <a href="{{ route('capabilities.index') }}" style="display:inline-flex;gap:8px;align-items:center;font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);margin-bottom:24px;">
      ← All capabilities
    </a>
    <span class="eyebrow reveal">{{ $capability->code ?? 'CAPABILITY' }} · {{ strtoupper($capability->eyebrow ?? '') }}</span>
    <h1 class="reveal d1" style="margin-top:18px">{{ $capability->title }}</h1>
    @if($capability->summary)
      <p class="hero-sub reveal d2">{{ $capability->summary }}</p>
    @endif
  </div>
</section>

<section style="padding: 0 0 clamp(80px, 9vw, 128px);">
  <div class="wrap" style="display:grid; grid-template-columns: 1fr 280px; gap: clamp(40px, 6vw, 80px);">
    <div class="reveal">
      <div class="body-prose">
        {!! \App\Support\Markdown::render($capability->body) !!}
      </div>
    </div>
    <aside class="reveal d1" style="position:sticky; top: 110px; align-self:flex-start;">
      @if($capability->methods)
        <div style="border:1px solid var(--rule-2); padding: 22px;">
          <div style="font-family:var(--mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);">Methods used</div>
          <ul style="list-style:none; margin: 14px 0 0; display:flex; flex-direction:column; gap: 8px;">
            @foreach($capability->methods as $idx => $m)
              <li style="font-family:var(--mono);font-size:11px;letter-spacing:.06em;text-transform:uppercase;padding:6px 10px;border:1px solid var(--rule-2);background:var(--steel-2); @if($idx===0)color:var(--amber);border-color:var(--amber-2);@else color:var(--txt);@endif">{{ $m }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      @if($capability->deliverables)
        <div style="border:1px solid var(--rule-2); padding: 22px; margin-top: 18px;">
          <div style="font-family:var(--mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);">Typical deliverables</div>
          <ul style="list-style:none; margin: 14px 0 0; display:flex; flex-direction:column; gap: 8px;">
            @foreach($capability->deliverables as $d)
              <li style="font-family:var(--mono);font-size:11px;letter-spacing:.06em;text-transform:uppercase;padding:6px 10px;border:1px solid var(--rule-2);background:var(--steel-2);color:var(--txt);">{{ $d }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </aside>
  </div>
</section>

@if($others->count())
  <section class="practice" style="background:var(--steel-2)">
    <div class="wrap">
      <div class="section-head reveal">
        <h2 class="disp-l">Other capabilities</h2>
        <div class="right" style="text-align:right">
          <a href="{{ route('capabilities.index') }}" style="color:var(--amber);font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;">View all →</a>
        </div>
      </div>
      <div class="practice-grid">
        @foreach($others as $i => $cap)
          <article class="practice-cell reveal d{{ $i + 1 }}">
            <div class="id">
              <span><span class="n">{{ $cap->code ?? '' }}</span></span>
              <span>{{ strtoupper($cap->eyebrow ?? '') }}</span>
            </div>
            <h3>{{ $cap->title }}</h3>
            <p class="body">{{ $cap->summary }}</p>
            <a href="{{ route('capabilities.show', $cap) }}" class="read" style="margin-top:auto;padding-top:18px;">
              Read the capability
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
