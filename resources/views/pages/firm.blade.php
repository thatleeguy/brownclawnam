@extends('layouts.site')
@section('title', 'Firm — Brownclaw Asset Management')
@section('description', 'Brownclaw Asset Management — nine years in mining and energy reliability across coal, diamond, gold, copper, and zinc.')

@section('content')
<section class="hero" style="padding-bottom:0">
  <div class="wrap">
    <span class="eyebrow reveal">THE FIRM · FILE 005</span>
    <h1 class="reveal d1" style="margin-top:18px">A small firm. <span class="am">Tier-1 work.</span></h1>
    <p class="hero-sub reveal d2">
      Brownclaw is a growing reliability and asset-management practice. Our
      engagement archive runs across tier-1 metallurgical coal preparation,
      sub-arctic diamond fleet programs, copper concentrators, and zinc
      smelters — and we're scaling the team to match the work that's coming
      in. Every engagement is led by an engineer on the floor, deliverables ship
      without a partner-stamp layer, and we hire engineers against the
      engagements they'll lead — never to fill a staffing matrix.
    </p>
  </div>
</section>

@include('partials.principal')

<section style="padding: 0 0 clamp(80px, 9vw, 128px);">
  <div class="wrap" style="max-width: 920px;">
    <div class="reveal">
      <h2 class="disp-l">How an engagement runs</h2>
      <ol style="list-style:none; padding:0; margin: 36px 0 0; display:flex; flex-direction:column; gap: 0;">
        @foreach([
          ['01', 'Discovery (no-cost)', 'Thirty-minute structured call. Bring the worst bad-actor on your floor; we identify whether reliability practice is the right tool. If it isn\'t, we say so.'],
          ['02', 'Scoping memorandum', 'A two-page brief: assumptions, deliverables, phases, fee, what we need from your team. No hidden retainers.'],
          ['03', 'Phase 1 — Establish baseline', 'CMMS extract, asset hierarchy review, criticality reset, bad-actor list. Two to four weeks.'],
          ['04', 'Phase 2 — Tactic library + pilot', 'Failure-mode-traced tactics on top-criticality assets, written in your CMMS. Operator training in-place.'],
          ['05', 'Phase 3 — Hand-off', 'Methods documented, your team trained on the workflow, KPI dashboard installed. We leave when your program runs without us.'],
        ] as $step)
          <li class="reveal" style="display:grid; grid-template-columns: 80px 1fr; gap: 24px; padding: 24px 0; border-bottom: 1px solid var(--rule-1);">
            <div class="cond" style="color: var(--amber); font-size: 22px;">{{ $step[0] }}</div>
            <div>
              <h3 style="font-family:var(--display);font-weight:700;font-size:20px;letter-spacing:-0.014em;">{{ $step[1] }}</h3>
              <p style="color: var(--txt-2); margin-top: 8px; max-width: 60ch; line-height:1.6;">{{ $step[2] }}</p>
            </div>
          </li>
        @endforeach
      </ol>
    </div>
  </div>
</section>

@include('partials.contact-cta')
@endsection
