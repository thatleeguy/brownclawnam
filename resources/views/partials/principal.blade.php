@php
  $team = ($team ?? null) ?: \App\Models\TeamMember::visible()->ordered()->get();
@endphp
@if($team->isNotEmpty())
<section class="principal" id="principal">
  @foreach($team as $member)
    <div class="wrap prin-grid"@if(! $loop->first) style="margin-top: clamp(48px, 6vw, 80px);"@endif>
      <figure class="prin-card reveal">
        <div class="figframe">
          @php
            $initials = \Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn($w) => \Illuminate\Support\Str::substr($w, 0, 1))->take(2)->implode('');
          @endphp
          <div class="prin-headshot">
            @if($member->photo)
              <img src="{{ asset($member->photo) }}"
                   alt="Portrait of {{ \Illuminate\Support\Str::title($member->name) }} of Brownclaw Asset Management."
                   onerror="this.style.display='none'; this.nextElementSibling.hidden=false;" />
              <span class="prin-initials" aria-hidden="true" hidden>{{ $initials }}</span>
            @else
              <span class="prin-initials" aria-hidden="true">{{ $initials }}</span>
            @endif
          </div>
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
