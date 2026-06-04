<div class="statusbar">
  <div class="wrap row">
    <div class="left">
      @if(filled($settings->statusbar_status_label) || filled($settings->statusbar_status_value))
        <span class="pill"><span class="led"></span> {{ $settings->statusbar_status_label }} <b>{{ $settings->statusbar_status_value }}</b></span>
      @endif
      @if(filled($settings->statusbar_location))
        <span class="clip">{{ $settings->statusbar_location }}</span>
      @endif
    </div>
    <div class="right">
      @if(filled($settings->statusbar_availability))
        <span class="clip">{!! $settings->statusbar_availability !!}</span>
      @endif
      @if(filled($settings->statusbar_creds))
        <span>{!! $settings->statusbar_creds !!}</span>
      @endif
    </div>
  </div>
</div>
