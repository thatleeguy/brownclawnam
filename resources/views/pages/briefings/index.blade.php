@extends('layouts.site')
@section('title', 'Briefings — Brownclaw Asset Management')
@section('description', 'Field briefings, technical memoranda, and methods notes on reliability engineering for heavy industry.')

@section('content')
<section class="hero" style="padding-bottom: 0;">
  <div class="wrap">
    <span class="eyebrow reveal">BRIEFINGS · FIELD MEMORANDA</span>
    <h1 class="reveal d1" style="margin-top:18px">Field briefings. <span class="am">Plain-spoken.</span></h1>
    <p class="hero-sub reveal d2">
      Technical memoranda, methods notes, and lessons-from-the-floor.
      Written for the people doing the work — free of consulting jargon.
    </p>
  </div>
</section>

<section class="briefings" style="border-top:0">
  <div class="wrap">
    <div class="brief-grid">
      @foreach($insights as $i => $insight)
        <article @class(['brief', 'reveal', 'd' . (($i % 3) + 1), 'lead' => $i === 0])>
          <div class="id">
            <span class="am">{{ $insight->code ?? 'BRIEF / ' . str_pad($insight->id, 3, '0', STR_PAD_LEFT) }}</span>
            <span><b>{{ strtoupper($insight->kicker ?? 'BRIEFING') }}</b> · {{ optional($insight->published_at)->format('d M y') }}@if($insight->reading_minutes) · {{ $insight->reading_minutes }} MIN @endif</span>
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
    <div style="margin-top: 36px;">{{ $insights->links() }}</div>
  </div>
</section>

@include('partials.contact-cta')
@endsection
