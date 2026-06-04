@if($settings->cta_visible)
<section class="contact" id="contact">
  <div class="wrap contact-inner">
    <div>
      <span class="eyebrow reveal">{{ $settings->cta_eyebrow ?: 'REQUEST · ENGAGEMENT INTAKE' }}</span>
      <h2 class="disp-xl reveal d1" style="margin-top:18px;">{!! $settings->cta_headline_html ?: 'If your reliability program isn\'t aging well, <span class="am">let\'s talk.</span>' !!}</h2>
      <p class="lede reveal d2">
        {{ $settings->cta_lede ?: 'First conversations are free and structured. Thirty minutes is usually enough to know whether we\'re a fit. Bring your worst bad-actor; we\'ll bring questions.' }}
      </p>
      <a href="{{ $settings->nav_cta_url ?: route('contact') }}" class="send reveal d3">
        {{ $settings->cta_button_label ?: 'REQUEST ENGAGEMENT' }}
        <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>

    <aside class="contact-card reveal d2">
      @if(filled($settings->contact_email))
      <div class="row">
        <div>
          <div class="l">DIRECT</div>
          <div class="v"><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></div>
          @if(filled($settings->contact_email_note))<div class="small">{{ $settings->contact_email_note }}</div>@endif
        </div>
      </div>
      @endif
      @if(filled($settings->contact_phone_display))
      <div class="row">
        <div>
          <div class="l">TELEPHONE</div>
          <div class="v"><a href="tel:{{ $settings->contact_phone_url ?: $settings->contact_phone_display }}">{{ $settings->contact_phone_display }}</a></div>
          @if(filled($settings->contact_phone_note))<div class="small">{{ $settings->contact_phone_note }}</div>@endif
        </div>
      </div>
      @endif
      @if(filled($settings->contact_location))
      <div class="row">
        <div>
          <div class="l">LOCATED</div>
          <div class="v">{{ $settings->contact_location }}</div>
          @if(filled($settings->contact_location_note))<div class="small">{{ $settings->contact_location_note }}</div>@endif
        </div>
      </div>
      @endif
    </aside>
  </div>
</section>
@endif
