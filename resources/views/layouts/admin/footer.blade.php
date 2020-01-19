

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
      @yield('page-js')

<script>


$( document ).ready(function() {
  $(function () {
    $('select').selectpicker({
      liveSearch: true
    });
  });
});


</script>
</body>
