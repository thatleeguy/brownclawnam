@php
    $vars = array_filter([
        '--amber'    => $settings->color_amber,
        '--amber-2'  => $settings->color_amber_2,
        '--steel-1'  => $settings->color_steel_1,
        '--steel-2'  => $settings->color_steel_2,
        '--steel-3'  => $settings->color_steel_3,
        '--txt'      => $settings->color_text,
        '--txt-2'    => $settings->color_text_2,
        '--hazard'   => $settings->color_hazard,
    ], fn ($v) => filled($v));
@endphp
@if(! empty($vars) || filled($settings->font_base_size))
<style>
  :root{
    @foreach($vars as $name => $value){{ $name }}: {{ $value }}; @endforeach
  }
  @if(filled($settings->font_base_size))
  body{ font-size: {{ (int) $settings->font_base_size }}px; }
  @endif
</style>
@endif
