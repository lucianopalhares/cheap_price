
<div class="footer">

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">footer 1</p>
                    <p class="pull-right"> footer 2 </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="loadingOverlay" style="display: none;">
    <div class="circleLoader"></div>
    <p>loading...</p>
</div>


<script src="{{ asset('site/js/vendor/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('site/js/vendor/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('site/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('site/select2-3.5.3/select2.min.js') }}"></script>
<script src="{{ asset('site/plugins/nprogress/nprogress.js') }}"></script>


<script type="text/javascript">
    NProgress.start();
    NProgress.done();
</script>

<script src="{{ asset('site/js/main.js') }}"></script>
<script>
    var toastr_options = {closeButton : true};
</script>
@yield('page-js')


</body>
</html>
