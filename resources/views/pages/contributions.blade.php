@extends('layouts.site')
@section('title', 'Contributions — Brownclaw Asset Management')
@section('description', 'Charities and community causes Brownclaw Asset Management has supported and given back to.')

@section('content')
<section class="hero" style="padding-bottom: clamp(32px, 5vw, 64px)">
  <div class="wrap">
    <span class="eyebrow reveal">CONTRIBUTIONS · GIVING BACK</span>
    <h1 class="reveal d1" style="margin-top:18px">Rooted in the communities <span class="am">we work in.</span></h1>
    <p class="hero-sub reveal d2">
      Reliability work takes us across Western Canada's mining and energy
      communities — and we make a point of giving back to them. Here are some
      of the charities and causes we've been proud to support.
    </p>
  </div>
</section>

<section style="padding: 0 0 clamp(80px, 9vw, 144px);">
  <div class="wrap">
    @if($contributions->isEmpty())
      <p class="hero-sub" style="color:var(--mute)">Contributions will be listed here soon.</p>
    @else
      @foreach($contributions->groupBy('year')->sortKeysDesc() as $year => $yearContributions)
        <section class="contrib-year-group" aria-labelledby="contrib-year-{{ $loop->index }}">
          <h2 class="contrib-year-heading" id="contrib-year-{{ $loop->index }}">{{ $year ?: 'Other contributions' }}</h2>
          <div class="contrib-grid">
            @foreach($yearContributions->values() as $i => $c)
              @php $href = $c->link ?: null; @endphp
              <{{ $href ? 'a' : 'article' }} @class(['contrib-card', 'reveal', 'd' . (($i % 3) + 1)]) @if($href) href="{{ $href }}" target="_blank" rel="noopener" @endif>
                <div class="contrib-photo">
                  @if($c->image)
                    <img src="{{ \App\Support\Media::url($c->image) }}" alt="{{ $c->title }}" loading="lazy" />
                  @endif
                </div>
                <div class="contrib-body">
                  <h3>{{ $c->title }}</h3>
                  @if($c->blurb)<p>{{ $c->blurb }}</p>@endif
                  @if($c->metric_value)
                    <div class="contrib-metric">
                      <span class="v">{{ $c->metric_value }}</span>
                      @if($c->metric_label)<span class="l">{{ $c->metric_label }}</span>@endif
                    </div>
                  @endif
                </div>
              </{{ $href ? 'a' : 'article' }}>
            @endforeach
          </div>
        </section>
      @endforeach
    @endif
  </div>
</section>

@include('partials.contact-cta')
@endsection
