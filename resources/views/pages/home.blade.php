@extends('layouts.site')

@section('title', 'Brownclaw Asset Management — Reliability Engineering for Heavy Industry')
@section('description', 'A reliability and asset-management practice for mining and energy operators. Based in Fernie, BC.')

@php
$levelMap = ['h' => ['HIGH', 'h'], 'm' => ['MED', 'm'], 'l' => ['LOW', 'l']];
$barClass = fn(int $score): string => 'b' . max(5, min(95, (int) round($score / 5) * 5));
@endphp

@section('content')

{{-- ============== HERO ============== --}}
<section class="hero">
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-text">
        <span class="eyebrow reveal">{{ $home->hero_eyebrow ?? 'Reliability Engineering · Asset Strategy · Mining & Energy' }}</span>

        <h1 class="reveal d1">
          {!! $home->hero_headline_html ?? 'We engineer <span class="kw">uptime</span><br/>on the iron <span class="am">that</span><br/><span class="am">moves the rock.</span>' !!}
        </h1>

        @if($home->hero_sub)
          <p class="hero-sub reveal d2">{{ $home->hero_sub }}</p>
        @endif

        <div class="hero-cta reveal d3">
          <a href="{{ route('contact') }}" class="btn btn-amber">
            {{ $home->hero_primary_cta_label ?? 'Request engagement' }}
            <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a href="{{ route('work.index') }}" class="btn btn-ghost">
            {{ $home->hero_secondary_cta_label ?? 'Recent work' }}
            <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>

        @if($home->spec_row)
          <div class="spec-row reveal d4">
            @foreach($home->spec_row as $spec)
              <div class="spec">
                <span class="l">{{ $spec['label'] ?? '' }}</span>
                <span class="v">{{ $spec['value'] ?? '' }}@if(!empty($spec['unit']))<small>{{ $spec['unit'] }}</small>@endif</span>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <figure class="hero-photo reveal d2">
        <div class="ph-head">
          <div class="left"><b>SITE / 047</b> &nbsp;·&nbsp; SURFACE MINE &nbsp;·&nbsp; HAUL ROAD</div>
          <div class="right">DOC · 03 / 2026</div>
        </div>
        <div class="ph-frame">
          <img src="{{ \App\Support\Media::url($home->hero_image) ?: asset('img/site-hero.jpg') }}" alt="Loaded ultra-class haul truck on a surface-mine haul road at dusk." />
          <span class="corner tl"></span>
          <span class="corner tr"></span>
          <span class="corner bl"></span>
          <span class="corner br"></span>
          <div class="ph-tag tag-tl">
            <span class="dot"></span>
            <b>HAUL FLEET</b>
            <small>ULTRA-CLASS TRUCK · LOADED</small>
          </div>
          <div class="ph-tag tag-br">
            <span class="dot amb"></span>
            <b>HAUL CYCLE</b>
            <small>ROM ORE · PIT TO CRUSHER</small>
          </div>
        </div>
        <div class="ph-foot">
          <span><b>WESTERN CANADA</b> · ENGAGEMENT ARCHIVE</span>
          <span>2025</span>
        </div>
      </figure>
    </div>
  </div>

  @php
    $commodities = $home->commodities ?: [
      ['name' => 'METALLURGICAL COAL', 'active' => true],
      ['name' => 'DIAMOND', 'active' => true],
      ['name' => 'GOLD', 'active' => true],
      ['name' => 'COPPER', 'active' => true],
      ['name' => 'ZINC', 'active' => true],
      ['name' => 'NUCLEAR', 'active' => true],
      ['name' => 'URANIUM', 'active' => true],
    ];
  @endphp
  <div class="ribbon">
    <div class="wrap row">
      <span class="label">{{ $home->ribbon_label ?: 'SECTOR EXPERIENCE / COMMODITY' }}</span>
      <ul>
        @foreach($commodities as $commodity)
          <li @class(['act' => $commodity['active'] ?? true])>{{ $commodity['name'] ?? '' }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

{{-- ============== POSITION ============== --}}
<section class="position" id="position">
  <div class="wrap grid">
    <aside class="label-col reveal">
      <h3>{{ $home->position_heading ?: 'What drives us' }}</h3>
    </aside>
    <div>
      @foreach(($home->position_paragraphs ?? []) as $i => $para)
        <p class="reveal d{{ $i + 1 }}">{!! is_array($para) ? ($para['text'] ?? '') : $para !!}</p>
      @endforeach
      <div class="signoff reveal d4">
        <span><b>{{ $home->position_signature_name ?? 'Connor Schriver · Founder' }}</b></span>
        <span>{{ $home->position_signature_note ?? 'SIG / 2026.04 / FERNIE BC' }}</span>
      </div>
    </div>
  </div>
</section>

@include('partials.hazstripe')

{{-- ============== PRACTICE ============== --}}
@if($home->practice_visible)
<section class="practice" id="practice">
  <div class="wrap">
    <div class="section-head reveal">
      <h2 class="disp-xl">{!! $home->practice_headline_html ?: 'Three capabilities. <span class="am">One discipline.</span>' !!}</h2>
      <div class="right">
        Each engagement combines all three to some degree. We scope tightly,
        deliver in documented phases, and leave behind the methods so your
        team runs the program when we leave.
      </div>
    </div>
    <div class="practice-grid">
      @foreach($capabilities as $i => $cap)
        <article class="practice-cell reveal d{{ $i + 1 }}">
          <div class="id">
            <span><span class="n">{{ $cap->code ?? 'CAP / ' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></span>
            <span>{{ strtoupper($cap->eyebrow ?? '') }}</span>
          </div>
          <h3>{{ $cap->title }}</h3>
          <p class="body">{{ $cap->summary }}</p>
          @if($cap->methods)
            <div class="deliv">
              <span class="dl">Methods used</span>
              <ul>
                @foreach($cap->methods as $idx => $m)
                  <li @class(['am' => $idx === 0])>{{ $m }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if($cap->deliverables)
            <div class="deliv">
              <span class="dl">Typical deliverables</span>
              <ul>
                @foreach($cap->deliverables as $d)<li>{{ $d }}</li>@endforeach
              </ul>
            </div>
          @endif
          <a href="{{ route('capabilities.show', $cap) }}" class="read">
            Read the capability
            <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ============== EVIDENCE ============== --}}
<section class="evidence" id="evidence">
  <div class="wrap">
    <div class="head reveal">
      <div>
        <span class="eyebrow">{{ $home->evidence_kicker ?? 'RESULTS / SELECTED ENGAGEMENTS' }}</span>
        <h2 class="disp-xl" style="margin-top:18px;">{!! $home->evidence_headline_html ?? 'Reliability is judged by what stays <span class="am">running.</span>' !!}</h2>
      </div>
      <div class="meta">{{ $home->evidence_meta ?? '' }}</div>
    </div>

    @if($home->kpi_metrics)
      <div class="kpi-grid">
        @foreach($home->kpi_metrics as $i => $m)
          @php
            $kpiHref = ! empty($m['link']) ? route('work.show', $m['link']) : null;
            $kpiTag = $kpiHref ? 'a' : 'div';
          @endphp
          <{{ $kpiTag }} @class(['kpi', 'reveal', 'd' . ($i + 1), 'is-link' => $kpiHref]) @if($kpiHref) href="{{ $kpiHref }}" @endif>
            <div class="head-row">
              <span class="nme">{{ $m['name'] ?? '' }}</span>
              <span class="src">{{ $m['source'] ?? '' }}</span>
            </div>
            <div class="v tabular">@if(!empty($m['unit_prefix']))<span class="pre">{{ $m['unit_prefix'] }}</span>@endif{{ $m['value_display'] ?? '' }}@if(!empty($m['unit']))<span class="u">{{ $m['unit'] }}</span>@endif</div>
            @if(!empty($m['delta_caption']))<div class="delta dn">{{ $m['delta_caption'] }}</div>@endif
            @if(!empty($m['description']))<div class="desc">{{ $m['description'] }}</div>@endif
            @if(!empty($m['context']))<div class="ctx">{{ $m['context'] }}</div>@endif
            @if($kpiHref)<span class="kpi-go" aria-hidden="true">View case study →</span>@endif
          </{{ $kpiTag }}>
        @endforeach
      </div>
    @endif
  </div>
</section>

{{-- ============== WORK / CASE ============== --}}
@if($home->work_visible)
<section class="work" id="work">
  <div class="wrap">
    <div class="section-head reveal">
      <h2 class="disp-xl">Evidence, <span class="am">not endorsements.</span></h2>
      <div class="right">
        Selected engagement. Numbers below are drawn directly from CMMS
        extracts at engagement start and engagement close.<br/><br/>
        <a href="{{ route('work.index') }}" style="color:var(--amber); font-family:var(--mono); font-size:11px; letter-spacing:.16em; text-transform:uppercase;">Browse the full archive →</a>
      </div>
    </div>

    @if($featuredCase)
      <article class="workcard reveal d1">
        <div class="text">
          <div class="meta">
            <span><b>{{ $featuredCase->code ?? 'WORK / ' . str_pad($featuredCase->id, 3, '0', STR_PAD_LEFT) }}</b> &nbsp;·&nbsp; {{ $featuredCase->client_display ?? $featuredCase->sector_label }}</span>
            <span>@if($featuredCase->engagement_months)<b>{{ $featuredCase->engagement_months }} MO</b> &nbsp;·&nbsp; @endif{{ $featuredCase->year ?? optional($featuredCase->published_at)->year }}</span>
          </div>
          <h3>{{ $featuredCase->title }}</h3>
          <p class="summary">{{ $featuredCase->summary }}</p>
          @if($featuredCase->kpi_stats)
            <div class="stats">
              @foreach($featuredCase->kpi_stats as $stat)
                <div class="stat">
                  <div class="v">{!! $stat['value'] ?? '' !!}@if(!empty($stat['unit']))<span class="am">{{ $stat['unit'] }}</span>@endif</div>
                  <div class="l">{{ $stat['label'] ?? '' }}</div>
                </div>
              @endforeach
            </div>
          @endif
          <a href="{{ route('work.show', $featuredCase) }}" class="read">
            Read the brief
            <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>

        <div class="visual" aria-hidden="true">
          <div class="stamp">
            <b>P&amp;ID-RV04</b>
            DENSE-MEDIUM CIRCUIT<br/>SIMPLIFIED · NTS
          </div>
          @include('partials.pid-svg')
        </div>
      </article>
    @endif

    @if($relatedCases->count() > 1)
      <div class="work-related">
        @foreach($relatedCases->reject(fn($c) => $featuredCase && $c->id === $featuredCase->id)->take(3) as $i => $rc)
          <a href="{{ route('work.show', $rc) }}" class="reveal d{{ $i + 2 }}">
            <span class="tag">{{ strtoupper($rc->sector_label ?? $rc->sector ?? 'CASE') }}@if($rc->region) · {{ strtoupper($rc->region) }}@endif</span>
            <h4>{{ $rc->title }}</h4>
            <span class="meta">
              @if($rc->engagement_months){{ $rc->engagement_months }} MO @endif
              @if($rc->year)· {{ $rc->year }}@endif
            </span>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endif

{{-- ============== CRITICALITY ============== --}}
@if($home->criticality_visible)
<section class="crit" id="criticality">
  <div class="wrap crit-grid">
    <div class="text reveal">
      <span class="eyebrow">{{ $home->criticality_eyebrow ?? 'METHOD / CRITICALITY' }}</span>
      <h2 class="disp-l" style="margin-top:18px;">{!! $home->criticality_headline_html ?? 'Where to spend the next reliability dollar — and where <span class="am">not to.</span>' !!}</h2>
      @if($home->criticality_lede_html)
        <p>{!! $home->criticality_lede_html !!}</p>
      @endif
      @if($home->criticality_checks)
        <div class="checks">
          @foreach($home->criticality_checks as $check)
            <div><span class="ch"></span><span>{!! is_array($check) ? ($check['text'] ?? '') : $check !!}</span></div>
          @endforeach
        </div>
      @endif
    </div>

    <div class="crit-matrix reveal d1">
      <div class="head"><span><b>REGISTER</b> · CRITICAL ASSETS · EXTRACT</span><span class="right">REV.04</span></div>
      <table>
        <thead><tr><th>TAG</th><th>EQUIPMENT</th><th>CRIT</th><th>HRS / MO</th><th>SCORE</th></tr></thead>
        <tbody>
          @foreach(($home->criticality_register ?? []) as $row)
            @php $lvl = $row['level'] ?? 'm'; @endphp
            <tr>
              <td class="id">{{ $row['tag'] ?? '' }}</td>
              <td class="eq">{{ $row['equipment'] ?? '' }}</td>
              <td><span class="pill {{ $lvl }}">{{ ['h' => 'HIGH', 'm' => 'MED', 'l' => 'LOW'][$lvl] ?? 'MED' }}</span></td>
              <td>{{ $row['hours'] ?? '' }}</td>
              <td><span class="bar {{ $barClass((int) ($row['score'] ?? 50)) }}"></span></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endif

{{-- ============== BRIEFINGS ============== --}}
@if($home->briefings_visible)
<section class="briefings" id="briefings">
  <div class="wrap">
    <div class="section-head reveal">
      <h2 class="disp-xl">{!! $home->briefings_headline_html ?? 'Field briefings. <span class="am">Plain-spoken.</span>' !!}</h2>
      <div class="right">{{ $home->briefings_meta ?? '' }}</div>
    </div>

    <div class="brief-grid">
      @foreach($insights as $i => $insight)
        <article @class(['brief', 'reveal', "d" . ($i + 1), 'lead' => $insight->is_lead || $i === 0])>
          <div class="id">
            <span class="am">{{ $insight->code ?? 'BRIEF / ' . str_pad($insight->id, 3, '0', STR_PAD_LEFT) }}</span>
            <span><b>{{ strtoupper($insight->kicker ?? 'BRIEFING') }}</b> · {{ optional($insight->published_at)->format('d M y') }} @if($insight->reading_minutes) · {{ $insight->reading_minutes }} MIN @endif</span>
          </div>
          <h3>{{ $insight->title }}</h3>
          <p class="excerpt">{{ $insight->excerpt }}</p>
          <a href="{{ route('briefings.show', $insight) }}" class="read">
            Read the brief
            <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>
      @endforeach
    </div>

    <div class="reveal" style="margin-top: 36px; display:flex; justify-content:flex-start;">
      <a href="{{ route('briefings.index') }}" class="btn btn-ghost">
        ARCHIVE
        <svg class="arr" width="13" height="9" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
</section>
@endif

{{-- ============== PRINCIPAL ============== --}}
@include('partials.principal')

@include('partials.hazstripe')

{{-- ============== CONTACT CTA ============== --}}
@include('partials.contact-cta')

@endsection
