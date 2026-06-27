<footer class="foot">
  <div class="wrap foot-row">
    @foreach($settings->footerLines() as $line)
      <span>{!! str_replace(':year', date('Y'), $line) !!}</span>
    @endforeach
  </div>
  <div class="wrap foot-credit-row">
    <a href="https://7am.ca" target="_blank" rel="noopener" class="foot-credit">Website by 7am</a>
  </div>
</footer>
