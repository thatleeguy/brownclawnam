<footer class="foot">
  <div class="wrap foot-row">
    @foreach($settings->footerLines() as $line)
      <span>{!! str_replace(':year', date('Y'), $line) !!}</span>
    @endforeach
  </div>
</footer>
