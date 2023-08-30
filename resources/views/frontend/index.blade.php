
@extends('frontend.layouts.master')
@section('main-content')

<div class="ijKKTW">
        <div class="ijKKTW_container">
            <div class="ijKKTW__content">
                <div class="cmc-global-stats__inner-content">
                    <div class="mHDBv">
                        <span class="sc-16891c57-0 mHDBv_child base-text">Nhà cung cấp:
                        </span>
                        <span class="sketch-highlight">&nbsp;37</span>
                    </div>
                    <div class="mHDBv">
                        <span class="sc-16891c57-0 mHDBv_child base-text">Shop con:
                        </span>
                        <span class="sketch-highlight">&nbsp;77</span>
                    </div>
                    <div class="mHDBv">
                        <span class="sc-16891c57-0 mHDBv_child base-text">Sản Phẩm:
                        </span>
                        <span class="sketch-highlight">&nbsp;140</span>
                    </div>
                    <div class="mHDBv">
                        <span class="sc-16891c57-0 mHDBv_child base-text">Tổng đơn hàng:
                        </span>
                        <span class="sketch-highlight">&nbsp;749</span>
                    </div>
                    <div class="mHDBv">
                        <span class="sc-16891c57-0 mHDBv_child base-text">Thành viên:
                        </span>
                        <span class="sketch-highlight">&nbsp;731</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Slider Area -->
@if(count($horizontal_banners)>0)
<section id="Gslider" class="carousel slide" data-ride="carousel">
    <div class="container mt-4 position-relative">
        <ol class="carousel-indicators">
            @foreach($horizontal_banners as $key=>$banner)
                <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner rounded" role="listbox">
                @foreach($horizontal_banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
                    {{-- <div class="carousel-caption d-none d-md-block text-left">
                        <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                        <p>{!! html_entity_decode($banner->description) !!}</p>
                        <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">{{ __('web.shop_now') }}<i class="far fa-arrow-alt-circle-right"></i></i></a>
                    </div> --}}
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">{{ __('web.previous') }}</span>
        </a>
        <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">{{ __('web.next') }}</span>
        </a>
    </div>
</section>
@endif

<!--/ End Slider Area -->

<!-- Start Product Area -->
<div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="shop-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget list-category">
                            <h3 class="title mb-0">{{ __('web.category') }}</h3>
                            @php
                                $categories = Helper::getAllCategory();
                            @endphp
                            <div id="mn-wrapper">
                                <div class="mn-sidebar">
                                    <div class="mn-toggle"><i class="fa fa-bars"></i></div>
                                    <div class="mn-navblock">
                                        <ul class="mn-vnavigation">
                                            @foreach($categories as $key1 => $lv1)
                                                @if($lv1->child_cat->count() > 0)
                                                    <li class="dropdown-submenu active">
                                                        <a tabindex="-1" href="{{route('product-cat', $lv1->slug)}}">{{$lv1->title}} <i class="fa fa-angle-right float-right mt-2"></i></a>
                                                        <ul class="dropdown-menu">
                                                            @foreach($lv1->child_cat as $key2 => $lv2)
                                                                @if($lv2->child_cat->count() > 0)
                                                                    <li class="dropdown-submenu active">
                                                                        <a href="{{route('product-cat', $lv2->slug)}}">{{$lv2->title}} <i class="fa fa-angle-right float-right mt-2"></i></a>
                                                                        <ul class="dropdown-menu parent">
                                                                            @foreach($lv2->child_cat as $key3 => $lv3)
                                                                                <li ><a href="{{route('product-cat', $lv3->slug)}}">{{$lv3->title}}</a></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @else
                                                                    <li><a href="{{route('product-cat', $lv2->slug)}}">{{$lv2->title}}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li><a href="{{route('product-cat', $lv1->slug)}}">{{$lv1->title}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- <div class="text-right collapse-button" style="padding:7px 9px;">

                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!--/ End Single Widget -->
                        <div class="banners mt-4">
                            @foreach($vertical_banners as $key=>$banner)
                                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                                    <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    
<!-- Start New Proudct List  -->
<section class="shop-home-list most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-section-title">
                    <h1>{{ __('web.product').' '.__('web.new') }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-1">
                @php
                    $new_product_lists = \App\Models\Product::where('status','active')->orderBy('id','DESC')->limit(6)->get();
                @endphp
                <div class="col-12 px-1">
                    <div class="owl-carousel popular-slider">
                        @foreach($new_product_lists as $product)
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        @php
                                            $photo=explode(',',$product->photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                        </div>
                                        <div class="product-link">
                                            @if(trim($product->link_youtube) != '')
                                                <a href="{{ $product->link_youtube }}" target="_blank"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube"/></a>
                                            @endif
                                            @if(trim($product->link_tiktok) != '')
                                                <a href="{{ $product->link_tiktok }}" target="_blank"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok"/></a>
                                            @endif
                                            @if(trim($product->link_facebook) != '')
                                                <a href="{{ $product->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook"/></a>
                                            @endif
                                        </div>
                                        <div class="product-action-2">
                                            <a href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                    <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                        @php
                                        $after_discount2=($product->price-($product->price*$product->discount)/100)
                                        @endphp
                                    
                                        <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                        <span class="product-price">{{number_format($after_discount2)}} VND</span>
                                        @if ($after_discount2 < $product->price)
                                            <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                        @endif
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->

<!-- Start Hot Proudct Popular -->
<div class="shop-home-list most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-section-title">
                    <h1>{{ __('web.product').' '.__('web.hot') }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-1">
                <div class="owl-carousel popular-slider">
                    @php
                        $hot_product_lists = \App\Models\Product::where('status','active')->where('condition','hot')->orderBy('id','DESC')->limit(6)->get();
                    @endphp
                    @foreach($hot_product_lists as $product)
                        @if($product->condition=='hot')
                            <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                        $photo=explode(',',$product->photo);
                                    @endphp
                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                    {{-- <span class="out-of-stock">Hot</span> --}}
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                    </div>
                                    <div class="product-link">
                                        @if(trim($product->link_youtube) != '')
                                            <a href="{{ $product->link_youtube }}" target="_blank"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube"/></a>
                                        @endif
                                        @if(trim($product->link_tiktok) != '')
                                            <a href="{{ $product->link_tiktok }}" target="_blank"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok"/></a>
                                        @endif
                                        @if(trim($product->link_facebook) != '')
                                            <a href="{{ $product->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook"/></a>
                                        @endif
                                    </div>
                                    <div class="product-action-2">
                                        <a href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                
                                        @php
                                        $after_discount3=($product->price-($product->price*$product->discount)/100)
                                        @endphp
                                    
                                        <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                        <span class="product-price">{{number_format($after_discount3)}} VND</span>
                                        @if ($after_discount3 < $product->price)
                                            <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                        @endif
                            </div>
                        </div>
                        <!-- End Single Product -->
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Discount Proudct Popular -->
<div class="shop-home-list most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-section-title">
                    <h1>{{ __('web.discount') }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-1">
                <div class="owl-carousel popular-slider">
                    @php
                        $discount_product_lists = \App\Models\Product::where('status','active')->orderBy('discount','DESC')->limit(6)->get();
                    @endphp
                    @foreach($discount_product_lists as $product)
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                        $photo=explode(',',$product->photo);
                                    @endphp
                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                    @if($product->discount)
                                        <span class="price-dec">{{$product->discount}}%</span>
                                    @endif
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                    </div>
                                    <div class="product-link">
                                        @if(trim($product->link_youtube) != '')
                                            <a href="{{ $product->link_youtube }}" target="_blank"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube"/></a>
                                        @endif
                                        @if(trim($product->link_tiktok) != '')
                                            <a href="{{ $product->link_tiktok }}" target="_blank"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok"/></a>
                                        @endif
                                        @if(trim($product->link_facebook) != '')
                                            <a href="{{ $product->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook"/></a>
                                        @endif
                                    </div>
                                    <div class="product-action-2">
                                        <a href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                
                                        @php
                                        $after_discount2=($product->price-($product->price*$product->discount)/100)
                                        @endphp
                                    
                                        <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                        <span class="product-price">{{number_format($after_discount2)}} VND</span>
                                        @if ($after_discount2 < $product->price)
                                            <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                        @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->
                    <div class="row">
                        @if($product_lists)
                            @foreach($product_lists as $key=>$product)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 p-b-35 pl-0 isotope-item {{$product->cat_id}}">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$product->slug)}}">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                            
                                            @if($product->stock<=0)
                                                <span class="out-of-stock">Tạm hết</span>
                                            @elseif($product->condition=='new')
                                                <span class="new">{{ __('web.new') }}</span>
                                            @elseif($product->condition=='hot')
                                                <span class="hot">{{ __('web.hot') }}</span>
                                            @elseif($product->discount)
                                                <span class="price-dec">{{$product->discount}}%</span>
                                            @endif
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a title="{{ __('web.add_to_wishlist') }}" href="{{route('add-to-wishlist',$product->slug)}}" ><i class="ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                            </div>
                                            <div class="product-link">
                                                @if(trim($product->link_youtube) != '')
                                                    <a href="{{ $product->link_youtube }}" target="_blank"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube"/></a>
                                                @endif
                                                @if(trim($product->link_tiktok) != '')
                                                    <a href="{{ $product->link_tiktok }}" target="_blank"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok"/></a>
                                                @endif
                                                @if(trim($product->link_facebook) != '')
                                                    <a href="{{ $product->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook"/></a>
                                                @endif
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                        <span class="product-price">{{number_format($after_discount)}} VND</span>
                                        @if ($after_discount < $product->price)
                                            <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{$product_lists->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Product Area -->


<!-- Start Shop Services Area -->
<section class="shop-services section home d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>{{ __('web.free_shiping') }}</h4>
                    <p>Đơn hàng trên 800K</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>{{ __('web.free_return') }}</h4>
                    <p>Đổi, trả trong 7 ngày</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>{{ __('web.secure_payment') }}</h4>
                    <p>100% Thanh toán an toàn</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>{{ __('web.best_price') }}</h4>
                    <p>Giá tốt nhất</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

@include('frontend.layouts.newsletter')

@endsection

@push('styles')

    <style>
        .ijKKTW {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 1em;
            font-weight: 500;
            line-height: 16px;
            position: relative;
            z-index: 930;
            overflow: hidden;
        }

        .ijKKTW_container {
            position: relative;
            width: 100%;
            max-width: 1400px;
            padding-right: 16px;
            padding-left: 16px;
            margin-right: auto;
            margin-left: auto;
        }

        .ijKKTW .ijKKTW__content {
            padding: 9px 16px;
            position: relative;
            white-space: nowrap;
            overflow: auto hidden;
            margin: auto;
            text-align-last: center;
        }

        .mHDBv {
            display: inline-block;
            font-weight: var(--c-font-weight-500);
            font-size: var(--c-font-size-50);
            padding: 0 0.5em;
        }

        .mHDBv_child {
            text-decoration: inherit;
            margin: 0px;
            padding: 0px;
            line-height: var(--c-line-height-body);
            display: initial;
            font-size: var(--c-font-size-50);
            color: var(--c-color-text-secondary);
            font-weight: inherit;
        }
        @-webkit-keyframes my {
        	 0% { color: #20c997; } 
        	 50% { color: #F8CD0A;  } 
        	 100% { color: #dc3545;  } 
         }
         @-moz-keyframes my { 
        	 0% { color: #20c997;  } 
        	 50% { color: #F8CD0A;  }
        	 100% { color: #dc3545;  } 
         }
         @-o-keyframes my { 
        	 0% { color:#20c997; } 
        	 50% { color: #F8CD0A; } 
        	 100% { color: #dc3545;  } 
         }
         @keyframes my { 
        	 0% { color: #20c997;  } 
        	 50% { color: #F8CD0A;  }
        	 100% { color: #dc3545;  } 
         } 
        .sketch-highlight{
          position:relative;
          padding: 0 6px;
          font-weight:bold;
        	 -webkit-animation: my 700ms infinite;
        	 -moz-animation: my 700ms infinite; 
        	 -o-animation: my 700ms infinite; 
        	 animation: my 700ms infinite;
        }
        
        .sketch-highlight:before{
          content:"";
          z-index:-1;
          left:0em;
          top:0em;
          border-width:2px;
          border-style:solid;
          border-color:mediumaquamarine;
          position:absolute;
          border-right-color:transparent;
          width:100%;
          height:1em;
          transform:rotate(2deg);
          opacity:0.5;
          border-radius:0.25em;
        }
        
        .sketch-highlight:after{
          content:"";
          z-index:-1;
          left:0em;
          top:0em;
          border-width:2px;
          border-style:solid;
          border-color:darkblue;
          border-left-color:transparent;
          border-top-color:transparent;
          position:absolute;
          width:100%;
          height:1em;
          transform:rotate(-1deg);
          opacity:0.5;
          border-radius:0.25em;
        }
    </style>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <style>
        
        #mn-wrapper {
        display: table;
        width: 100%;
        height: auto;
        /* min-height: 300px; */
        }
        .mn-sidebar {
        display: table-cell;
        position: relative;
        vertical-align: top;
        /* padding-bottom: 49px; */
        background: #fff;
        width: 100%;
        z-index: 2;
        }

        .mn-sidebar .mn-toggle {
        display: none;
        padding: 10px 0;
        text-align: center;
        cursor: pointer;
        }
        .mn-vnavigation {
        margin: 0 0 0 0;
        padding: 0;
        }
        .mn-vnavigation li a {
        border-bottom: 1px solid #f1f1f1;
        display: block;
        padding: 7px 10px;
        color: #495057;
        text-decoration: none;
        white-space: nowrap;
        }
        .mn-vnavigation li a:hover {
            background: #f1f1f1;
        }
        .mn-sidebar .dropdown-submenu{
            position: unset;
        }
        .mn-sidebar .dropdown-submenu > .dropdown-menu {
            top: -1px;
            left: 100%;
            min-width: 250px;
            width: auto;
            background: #fff;
            height: 300px;
            padding: 0;
            border-radius: 1px;
            border: 1px solid #f1f1f1;
        }
        .mn-sidebar .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        .mn-sidebar .dropdown-submenu > a:after {
            content: " ";
            
        }
        .mn-sidebar  .dropdown-submenu:hover > a:after {
            border-left-color: #fff;
        }
        .mn-sidebar  .dropdown-submenu.pull-left {
            float: none;
        }
        .mn-sidebar  .dropdown-submenu.pull-left > .dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }
        .mn-sidebar ul {
            list-style: none;
        }

        .pagination{
            display:inline-flex;
            margin-top: 20px !important;
        }

        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
        height: auto;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            /* opacity: .8; */
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
<script>

    $('.child').hide();

    $('.parent').children().click(function () {
        event.preventDefault();
        $(this).children('.child').slideToggle('slow');
        $(this).find('span').toggle();
    });

    /*==================================================================
    [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function () {
        $filter.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({filter: filterValue});
        });

    });

    // init Isotope
    $(window).on('load', function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine : 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function(){
        $(this).on('click', function(){
            for(var i=0; i<isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });

    // $(function() {
        
    //     $('.list-group-item').on('click', function() {
    //         $('.fa', this)
    //         .toggleClass('fa-angle-right')
    //         .toggleClass('fa-angle-down');
    //     });
    
    // });

</script>
<script>
        function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
</script>

@endpush
