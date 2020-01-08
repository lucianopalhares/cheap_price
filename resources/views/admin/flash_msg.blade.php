@if(session('success'))
    <div class="alert alert-sucess text-center" role="alert">
        {!! session('success') !!}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center" role="alert">
        {!! session('error') !!}
    </div>
@endif