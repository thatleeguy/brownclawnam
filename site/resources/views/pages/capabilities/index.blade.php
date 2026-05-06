@extends('layouts.site')
@section('title', 'Capabilities — Brownclaw Asset Management')
@section('description', 'Reliability engineering, asset strategy, and maintenance & reliability assessments for mining and energy operators.')

@section('content')
<section class="hero" style="padding-bottom:0">
  <div class="wrap">
    <span class="eyebrow reveal">CAPABILITIES / 01–{{ str_pad($capabilities->count(), 2, '0', STR_PAD_LEFT) }}</span>
    <h1 class="reveal d1" style="margin-top:18px">Three capabilities. <span class="am">One discipline.</span></h1>
    <p class="hero-sub reveal d2">
      Each engagement combines all three to some degree. We scope tightly,
      deliver in documented phases, and leave behind the methods so your
      team runs the program when we leave.
    </p>
  </div>
</section>

<section class="practice" style="border-top:0">
  <div class="wrap">
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
                @foreach($cap->methods as $idx => $m)<li @class(['am' => $idx === 0])>{{ $m }}</li>@endforeach
              </ul>
            </div>
          @endif
          @if($cap->deliverables)
            <div class="deliv">
              <span class="dl">Typical deliverables</span>
              <ul>@foreach($cap->deliverables as $d)<li>{{ $d }}</li>@endforeach</ul>
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

@include('partials.contact-cta')
@endsection
