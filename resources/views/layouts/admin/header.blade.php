<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-BR"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    @yield('page-css')



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{{ config('app.name', 'Laravel') }}</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="{{ __('app.search') }}" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        
            
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('app.logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>            
            
      
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              
              
              <li class="nav-item" >
                <a class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{url('/admin/dashboard')}}">
                  <span data-feather="home"></span>
                  Dashboard
                </a>
              </li>
              

              <li class="nav-item" >
                <a class="nav-link {{ (request()->is('admin/category/*')) ? 'active' : '' }} {{ (request()->is('admin/category')) ? 'active' : '' }}" data-toggle="collapse" href="#componentsCollapseCategory" aria-expanded="false">
                  <span data-feather="grid"></span>
                  {{trans('app.category')}}
                </a>
                <div class="collapse {{ (request()->is('admin/category/*')) ? 'show' : '' }} {{ (request()->is('admin/category')) ? 'show' : '' }}" id="componentsCollapseCategory">
                  <ul class="nav">
                    <li class="nav-item">
                      <a class="nav-link {{ (request()->is('admin/category')) ? 'active' : '' }}" href="{{url('/admin/category')}}">
                        &nbsp;<span data-feather="arrow-right"></span>&nbsp;{{trans('app.categories')}}
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link {{ (request()->is('admin/category/create')) ? 'active' : '' }}" href="{{url('/admin/category/create')}}">
                        &nbsp;<span data-feather="arrow-right"></span>&nbsp;{{trans('app.create')}} {{trans('app.category')}}
                      </a>
                    </li>                    
                  </ul>
                </div>
              </li>
            
            
            
            
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Admin</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                Test
                </a>
              </li>
            
            </ul>
          </div>
        </nav>

      