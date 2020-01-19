<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-BR"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>title</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap-theme.min.css') }}">
    <!-- Font awesome 4.4.0 -->
    <link rel="stylesheet" href="{{ asset('site/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <!-- load page specific css -->

    <!-- main select2.css -->
    <link href="{{ asset('site/select2-3.5.3/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('site/select2-3.5.3/select2-bootstrap.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('site/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/plugins/nprogress/nprogress.css') }}">


    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">

        @yield('page-css')



    <script src="{{ asset('site/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->



<div class="header-nav-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12 ">
                <div class="topContactInfo">
                    <ul class="nav nav-pills">
                    
                            <li>
                                <a href="callto:/5565656565656">
                                    <i class="fa fa-phone"></i>
                                    +5565656565656
                                </a>
                            </li>
                      

                  
                            <li>
                                <a href="mailto:email@email.com">
                                    <i class="fa fa-envelope"></i>
                                    email@email.com
                                </a>
                            </li>
                    
                    </ul>
                </div>

            </div>
            <div class="col-md-8 col-sm-12">
        
                <div class="topContactInfo">
                    <ul class="nav nav-pills navbar-right">
                        <li>
                            <a href="#">
                                <i class="fa fa-user"></i>
                              oi, Visitante </a>
                        </li>
                        <li>
                            <a href="">

                                SEJA BEM-VINDO(a) </a>
                        </li>

                    </ul>
                </div>
        

            </div>
        </div>
    </div>

</div>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">
                name
                        <img src="">
              

            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">

              <li><a href="{{url('/login')}}"> <i class="fa fa-lock"></i>  login  </a>  </li>
              
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Idioma <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="">English</a></li>
                                
                            </ul>
                        </li>
              
            </ul>


        </div><!--/.navbar-collapse -->
    </div>
</nav>
