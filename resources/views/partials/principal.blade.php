@php
  $team = ($team ?? null) ?: \App\Models\TeamMember::visible()->ordered()->get();
@endphp
@if($team->isNotEmpty())
<section class="principal" id="principal">
  @foreach($team as $member)
    <div class="wrap prin-grid"@if(! $loop->first) style="margin-top: clamp(48px, 6vw, 80px);"@endif>
      <figure class="prin-card reveal">
        <div class="head">
          <span><b>{{ $member->file_label ?: 'FILE' }}</b>@if($member->badge_label) · {{ $member->badge_label }}@endif</span>
          <span class="am">ACTIVE</span>
        </div>
        <div class="figframe">
          <div class="prin-headshot">
            <img src="{{ asset($member->photo ?: 'img/connor.jpg') }}"
                 alt="Portrait of {{ \Illuminate\Support\Str::title($member->name) }} of Brownclaw Asset Management." />
          </div>
          <svg class="prin-reg" viewBox="0 0 400 480" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
            <g stroke="#F2A82A" stroke-width="0.7" fill="none" opacity="0.7">
              <circle cx="350" cy="60" r="10"/>
              <line x1="340" y1="60" x2="360" y2="60"/>
              <line x1="350" y1="50" x2="350" y2="70"/>
            </g>
            <text x="320" y="84" font-family="IBM Plex Mono, monospace" font-size="8" fill="#F2A82A" letter-spacing="1.5">{{ $member->frame_label ?: 'FRAME' }}</text>
          </svg>
        </div>
        <div class="nameblock">
          <div>
            <div class="nm">{{ $member->name }}</div>
            @if($member->title)<div class="ti">{{ $member->title }}</div>@endif
          </div>
          @if($member->creds)
            <div class="creds">{!! str_replace('/', '<br/>', e($member->creds)) !!}</div>
          @endif
        </div>
      </figure>

      <div class="prin-body">
        @if($member->eyebrow)<span class="eyebrow reveal">{{ $member->eyebrow }}</span>@endif
        @if($member->headline_html)
          <h2 class="disp-l reveal d1" style="margin-top:18px;">{!! $member->headline_html !!}</h2>
        @endif
        @if($member->bio_html)
          <p class="lede reveal d2">{!! $member->bio_html !!}</p>
        @endif
        @if($member->quote)
          <blockquote class="quote reveal d3">{!! $member->quote !!}</blockquote>
          @if($member->quote_sign)<div class="qsign reveal d3">{{ $member->quote_sign }}</div>@endif
        @endif
        @if($member->cv)
          <div class="cv reveal d4">
            @foreach($member->cv as $cell)
              <div><div class="l">{{ $cell['label'] ?? '' }}</div><div class="v">{!! $cell['value'] ?? '' !!}</div></div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  @endforeach
</section>
@endif
