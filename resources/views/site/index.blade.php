@extends('layouts.site.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('site/plugins/owl.carousel/assets/owl.carousel.css') }}">
@endsection

@section('main')
    <div class="modern-top-intoduce-section">

        <div class="container">
            <div class="row">
                <div class="col-md-5">

                    <div class="mdern-top-introduce-left">
                        <div class="alert alert-warning">
                            <h2>name</h2>
                            <p><i class='fa fa-check'></i> first</p>
                        </div>
                    </div>

                    </div>
                <div class="col-md-7">

                    <div class="mdern-top-introduce-left">
                        <h1>right title</h1>

                        <p>right content</p>

  
                        <a href="" class="btn btn-info btn-lg">post an add
                          <small>post an add small</small>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modern-top-hom-cat-section">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="modern-home-search-bar-wrap">
                        <div class="search-wrapper">
                            <form class="form-inline" action="" method="get">
                                <div class="form-group">
                                    <input type="text"  class="form-control" id="searchTerms" name="q" value="" placeholder="" />
                                </div>
                                

                                <div class="form-group">
                                    <select class="form-control select2" name="product">
                                        <option value="">Selecione o Produto</option>
                                    
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control select2" name="user_id">
                                        <option value="">selecione o usuario</option>
                                    
                                    </select>
                                </div>

                                <button type="submit" class="btn theme-btn"> <i class="fa fa-search"></i> Buscar</button>
                            </form>
                        </div>

                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>

    </div>

<!--foreach 1 -->

  <!-- has -->
        <div class="container">
            <div class="row" >

                <div class="col-sm-12" >
                  <!--
                    <div class="carousel-header">
                        <h4><a href="">
                              
                            </a>
                        </h4>
                    </div>
                    <hr />
                  -->
                <br>
                    <div class="themeqx_new_premium_ads_wrap themeqx-carousel-ads">

                        <!-- foreach has -->

                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-test" >
                                    <div class="ads-thumbnail">
                                        <!--<a href="">-->
                                            <img itemprop="image"  src="" class="img-responsive" alt="">

                                            <!--
                                            <span class="modern-img-indicator">




                                            </span>-->
                                        <!--</a>-->
                                    </div>
                                  <div class="caption">
                                        <h4>
                                        <!--<a href="" title="">-->
                                        <span itemprop="name">seller name</span>
                                        <!--</a>-->
                                        </h4>

                                        <!--<a class="location text-muted" href="" >-->

                                          <span>
                                          <i>({{ str_limit('name product', 100) }})</i>
                                          </span>
                                        <!--</a>-->

                                        <!--<a class="text-danger" href="#"><i class="fa fa-heart text-danger"></i> </a>
-->
                                    </div>


                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">R$ 100</div></div>

                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">Até 25/12</div></div>

                                </div>


                        <!-- end has foreach -->
                    </div>
                </div>

            </div>
        </div>
   <!-- end has -->
<!-- end foreach -->

@endsection

@section('page-js')
    <script src="{{ asset('site/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".themeqx_new_premium_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

        $(document).ready(function(){
            $(".themeqx_new_regular_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });
        $(document).ready(function(){
            $(".home-latest-blog").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

    </script>

@endsection
