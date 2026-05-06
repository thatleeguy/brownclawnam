@extends('layouts.site')
@section('title', 'Work — Brownclaw Asset Management')
@section('description', 'Selected reliability and asset-management engagements with mining and energy operators.')

@section('content')
<section class="hero" style="padding-bottom:0">
  <div class="wrap">
    <span class="eyebrow reveal">WORK · ENGAGEMENT ARCHIVE</span>
    <h1 class="reveal d1" style="margin-top:18px">Evidence, <span class="am">not endorsements.</span></h1>
    <p class="hero-sub reveal d2">
      Selected engagements from the last 36 months. Numbers below are
      drawn directly from operator-side CMMS / historian extracts.
    </p>
  </div>
</section>

<section class="work" style="border-top:0">
  <div class="wrap">
    <div class="brief-grid" style="border:1px solid var(--rule-2); display:grid; grid-template-columns:repeat(2,1fr);">
      @foreach($cases as $i => $c)
        <article class="brief reveal d{{ ($i % 4) + 1 }}" style="border-right:1px solid var(--rule-1); border-bottom:1px solid var(--rule-1); min-height: 320px;">
          <div class="id">
            <span class="am">{{ $c->code ?? 'WORK / ' . str_pad($c->id, 3, '0', STR_PAD_LEFT) }}</span>
            <span><b>{{ strtoupper($c->sector_label ?? $c->sector ?? 'CASE') }}</b>@if($c->region) · {{ strtoupper($c->region) }}@endif</span>
          </div>
          <h3 style="font-size:clamp(22px, 1.9vw, 28px);">{{ $c->title }}</h3>
          @if($c->summary)<p class="excerpt">{{ \Illuminate\Support\Str::limit($c->summary, 220) }}</p>@endif
          @if($c->kpi_stats)
            <div style="display:flex;gap:18px;flex-wrap:wrap;font-family:var(--mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--mute);">
              @foreach(array_slice($c->kpi_stats, 0, 3) as $s)
                <span><b style="color:var(--amber);font-family:var(--display);font-size:14px;">{!! $s['value'] !!}{!! $s['unit'] ?? '' !!}</b> {{ $s['label'] }}</span>
              @endforeach
            </div>
          @endif
          <a href="{{ route('work.show', $c) }}" class="read">
            Read the brief
            <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>
      @endforeach
    </div>

    <div style="margin-top: 36px;">{{ $cases->links() }}</div>
  </div>
</section>

@include('partials.contact-cta')
@endsection
