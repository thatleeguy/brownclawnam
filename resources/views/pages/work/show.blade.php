@extends('layouts.site')
@section('title', $case->title . ' — Brownclaw Asset Management')
@section('description', \Illuminate\Support\Str::limit(strip_tags($case->summary), 160))

@push('head')
<style>
.body-prose{ max-width: 70ch; color: var(--txt-2); font-size: var(--fs-body); line-height: 1.7; }
.body-prose h2{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: clamp(24px, 2.4vw, 34px); letter-spacing: -0.02em; margin: 56px 0 16px; line-height: 1.1; }
.body-prose h3{ font-family: var(--display); font-weight: 700; color: var(--txt); font-size: 20px; letter-spacing: -0.014em; margin: 36px 0 10px; }
.body-prose p, .body-prose ul, .body-prose ol{ margin: 0 0 1.05em; }
.body-prose ul, .body-prose ol{ padding-left: 1.4em; }
.body-prose li{ margin-bottom: 0.4em; }
.body-prose strong{ color: var(--txt); font-weight: 600; }
.body-prose blockquote{ border-left: 3px solid var(--amber); padding: 12px 18px; margin: 24px 0; background: var(--steel-2); color: var(--txt); }
.body-prose a{ color: var(--amber); text-decoration: underline; text-underline-offset: 3px; }
</style>
@endpush

@section('content')
<section class="hero" style="padding-bottom: clamp(48px, 6vw, 80px);">
  <div class="wrap">
    <a href="{{ route('work.index') }}" style="display:inline-flex;gap:8px;align-items:center;font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);margin-bottom:24px;">
      ← All work
    </a>
    <span class="eyebrow reveal">{{ $case->code ?? 'WORK' }} · {{ strtoupper($case->sector_label ?? $case->sector ?? '') }}@if($case->region) · {{ strtoupper($case->region) }}@endif</span>
    <h1 class="reveal d1" style="margin-top:18px;">{{ $case->title }}</h1>
    @if($case->summary)
      <p class="hero-sub reveal d2">{{ $case->summary }}</p>
    @endif

    @if($case->kpi_stats)
      <div class="kpi-grid reveal d3" style="margin-top: 48px;">
        @foreach($case->kpi_stats as $i => $s)
          <div class="kpi" style="min-height: auto; padding: 26px 22px;">
            <div class="head-row">
              <span class="nme">{{ strtoupper($s['label'] ?? '') }}</span>
            </div>
            <div class="v tabular">{!! $s['value'] !!}@if(!empty($s['unit']))<span class="u">{{ $s['unit'] }}</span>@endif</div>
            @if(!empty($s['note']))<div class="desc">{{ $s['note'] }}</div>@endif
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

<section style="padding: 0 0 clamp(80px, 9vw, 128px);">
  <div class="wrap" style="display:grid; grid-template-columns: 1fr 280px; gap: clamp(40px, 6vw, 80px);">
    <div class="reveal">
      <div class="body-prose">
        {!! \App\Support\Markdown::render($case->body) !!}
      </div>
    </div>
    <aside class="reveal d1" style="position:sticky; top: 110px; align-self:flex-start;">
      <div style="border:1px solid var(--rule-2); padding: 22px; background: var(--steel-2);">
        <div style="font-family:var(--mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--mute);">Engagement</div>
        <dl style="margin-top:14px; display:flex; flex-direction:column; gap: 12px; font-family:var(--mono); font-size:12px;">
          @if($case->client_display)<div><dt style="color:var(--mute); font-size:10px; letter-spacing:.16em; text-transform:uppercase;">Client</dt><dd style="color:var(--txt); margin-top:4px;">{{ $case->client_display }}</dd></div>@endif
          @if($case->sector_label)<div><dt style="color:var(--mute); font-size:10px; letter-spacing:.16em; text-transform:uppercase;">Sector</dt><dd style="color:var(--txt); margin-top:4px;">{{ $case->sector_label }}</dd></div>@endif
          @if($case->region)<div><dt style="color:var(--mute); font-size:10px; letter-spacing:.16em; text-transform:uppercase;">Region</dt><dd style="color:var(--txt); margin-top:4px;">{{ $case->region }}</dd></div>@endif
          @if($case->engagement_months)<div><dt style="color:var(--mute); font-size:10px; letter-spacing:.16em; text-transform:uppercase;">Duration</dt><dd style="color:var(--txt); margin-top:4px;">{{ $case->engagement_months }} months</dd></div>@endif
          @if($case->year)<div><dt style="color:var(--mute); font-size:10px; letter-spacing:.16em; text-transform:uppercase;">Year</dt><dd style="color:var(--txt); margin-top:4px;">{{ $case->year }}</dd></div>@endif
        </dl>
      </div>
    </aside>
  </div>
</section>

@if($related->count())
  <section class="work" style="background:var(--steel-2)">
    <div class="wrap">
      <div class="section-head reveal">
        <h2 class="disp-l">More work</h2>
        <div class="right" style="text-align:right">
          <a href="{{ route('work.index') }}" style="color:var(--amber);font-family:var(--mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;">Browse the archive →</a>
        </div>
      </div>
      <div class="work-related" style="border-top:1px solid var(--rule-1)">
        @foreach($related as $i => $rc)
          <a href="{{ route('work.show', $rc) }}" class="reveal d{{ $i + 1 }}">
            <span class="tag">{{ strtoupper($rc->sector_label ?? $rc->sector ?? '') }}@if($rc->region) · {{ strtoupper($rc->region) }}@endif</span>
            <h4>{{ $rc->title }}</h4>
            <span class="meta">@if($rc->engagement_months){{ $rc->engagement_months }} MO @endif@if($rc->year)· {{ $rc->year }}@endif</span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
@endif

@include('partials.contact-cta')
@endsection
