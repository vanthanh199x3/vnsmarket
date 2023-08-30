@extends('frontend.layouts.master')
@section('title', config('app.name').' - '. __('web.product_list'))
@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
                            @if (isset($breadcrumb) && $breadcrumb != '')
                                <li class="active"><a href="javascript:void(0);">{{ $breadcrumb }}</a></li>
                            @else
                                <li class="active"><a href="javascript:void(0);">{{ __('web.product_list') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Product Style -->
    <form action="{{route('shop.filter')}}" method="POST">
        @csrf

        <input type="hidden" name="category" value="{{ $categorySlug ?? '' }}">
        <input type="hidden" name="brand" value="{{ $brandSlug ?? '' }}">

        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
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
                                <!-- Shop By Price -->
                                <div class="single-widget range">
                                    <h3 class="title">{{ __('web.filter_by_price') }}</h3>
                                    <div class="price-filter">
                                        <div class="price-filter-inner">
                                            @php
                                                $max=DB::table('products')->max('price');
                                                // dd($max);
                                            @endphp
                                            <div id="slider-range" data-min="0" data-max="{{$max}}"></div>
                                            <div class="product_filter">
                                                <div class="label-input">
                                                    <span>{{ __('web.product_price') }}:</span>
                                                    <input type="text" id="amount" readonly/>
                                                    <input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"/>
                                                </div>
                                                <button type="submit" class="filter_button">{{ __('web.filter') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--/ End Shop By Price -->
                                <!-- Single Widget -->
                                <div class="single-widget recent-post d-none">
                                    <h3 class="title">{{ __('web.recent_post') }}</h3>
                                    {{-- {{dd($recent_products)}} --}}
                                    @foreach($recent_products as $product)
                                        <!-- Single Post -->
                                        @php
                                            $photo=explode(',',$product->photo);
                                        @endphp
                                        <div class="single-post first">
                                            <div class="image">
                                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            </div>
                                            <div class="content">
                                                <h5><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h5>
                                                @php
                                                    $org=($product->price-($product->price*$product->discount)/100);
                                                @endphp
                                                <p class="price"><del class="text-muted">{{number_format($product->price)}} VND</del>
                                                @if($product->discount > 0)
                                                    {{number_format($org)}} VND  </p>
                                                @endif

                                            </div>
                                        </div>
                                        <!-- End Single Post -->
                                    @endforeach
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Single Widget -->
                                <div class="single-widget brands">
                                    <h3 class="title">{{ __('web.brand') }}</h3>
                                    <ul class="brand-list">
                                        @php
                                            $brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                                        @endphp
                                        @foreach($brands as $brand)
                                            <li><a href="{{route('product-brand',$brand->slug)}}"><i class="ti-angle-right"></i> {{$brand->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12 px-2">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>{{ __('web.show') }} :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">{{ __('web.default') }}</option>
                                                <option value="24" @if(!empty($_GET['show']) && $_GET['show']=='24') selected @endif>24</option>
                                                <option value="36" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>36</option>
                                                <option value="48" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>48</option>
                                                <option value="60" @if(!empty($_GET['show']) && $_GET['show']=='60') selected @endif>60</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>{{ __('web.sort_by') }} :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">{{ __('web.default') }}</option>
                                                <option value="price_low_to_high" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price_low_to_high') selected @endif>Giá thấp đến cao</option>
                                                <option value="price_high_to_low" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price_high_to_low') selected @endif>Giá cao đến thấp</option>
                                                <option value="hot" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='hot') selected @endif>Sản phẩm Hot</option>
                                                <option value="new" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='new') selected @endif>Sản phảm Mới</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode d-none">
                                        <li class="active"><a href="javascript:void(0)"><i class="ti-layout-grid2"></i></a></li>
                                        <li><a href="{{route('product-lists')}}"><i class="ti-view-list-alt"></i></a></li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            {{-- {{$products}} --}}
                            @if(count($products)>0)
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail',$product->slug)}}">
                                                    @php
                                                        $photo=explode(',',$product->photo);
                                                    @endphp
                                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                                    @if($product->discount)
                                                                <span class="price-dec">{{$product->discount}} % Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" class="wishlist" data-id="{{$product->id}}"><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                                    </div>
                                                    <div>
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
                                                        <a title="{{ __('web.add_to_cart') }}" href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
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
                                                @if($product->price > $after_discount)
                                                    <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <p class="text-secondary" style="margin:100px auto;"><i class="ti-info-alt"></i> {{ __('web.no_product') }}</p>
                            @endif

                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{$products->appends($_GET)->links()}}
                            </div>
                          </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

    <!--/ End Product Style 1  -->


@endsection
@push('styles')
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
    }
    .filter_button{
        text-align: center;
        background:#ffc50c;
        padding:8px 16px;
        margin-top:10px;
        color: white;
        border: 0;
    }
</style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
                    else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush
