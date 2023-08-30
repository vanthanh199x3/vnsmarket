@php
    $setting = DB::table('settings')->first();
@endphp
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-6">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <li>
                                <a href="tel:{{ preg_replace('/\D/', '', $setting->phone) ?? '' }}">
                                    <i class="ti-headphone-alt"></i>{{ $setting->phone }}
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ $setting->email }}">
                                    <i class="ti-email"></i>{{ $setting->email }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-6 col-6">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            @auth
                            
                                <!--@if(!\Helper::isMobile())-->
                                <!--    <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">{{ __('web.track_order') }}</a></li>-->
                                <!--@endif-->
                                    <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">{{ __('web.track_order') }}</a></li>

                                @if(Auth::user()->role == 'admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">{{ __('web.dashboard') }}</a></li>
                                @else
                                    <li><i class="ti-user"></i> <a href="{{route('web.user.profile')}}">{{ __('web.dashboard') }}</a></li>
                                @endif

                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">{{ __('web.logout') }}</a></li>
                            @else
                                <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">{{ __('web.track_order') }}</a></li>
                                <li>
                                    <i class="ti-user"></i>
                                    <a href="{{route('login.form')}}">{{ __('web.login') }}</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">                  
                        <a href="{{route('home')}}">
                            @if ($setting->logo != '')
                        	    <img width="200" src="{{$setting->logo}}" alt="logo">
                            @else
                                <h3 class="text-light mt-4">{{ env('APP_NAME') }}</h3>
                            @endif
                        </a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <a href="{{route('wishlist')}}"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>
                        <a href="{{route('cart')}}"><i class="ti-bag" style="font-size:16px"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                        <div class="top-search d-inline-block"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form" method="GET" action="{{route('product.search')}}">
                                <input type="text" placeholder="{{ __('web.search_product') }}" name="search">
                                <button value="search" type="submit">
                                    <i class="ti-search"  style="color: gray;"></i>
                                    </button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav">
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <!--<select>-->
                            <!--    <option>{{ __('web.all_category') }}</option>-->
                            <!--    @foreach(Helper::getAllCategory() as $cat)-->
                            <!--        <option>{{$cat->title}}</option>-->
                            <!--    @endforeach-->
                            <!--</select>-->
                            <form method="GET" action="{{route('product.search')}}">
                                <input name="search" placeholder="{{ __('web.search_product') }}" type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php 
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                           @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                           @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} {{ __('web.product') }}</span>
                                        <a href="{{route('wishlist')}}">{{ __('web.view_wishlist') }}</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromWishlist() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">{{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>{{ __('web.total') }}</span>
                                            <span class="total-amount">{{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">{{ __('web.cart') }}</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        {{-- <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div> --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag" style="font-size:16px"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromCart()) }} {{ __('web.product') }}</span>
                                        <a href="{{route('cart')}}">{{ __('web.view_cart') }}</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">{{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>{{ __('web.total') }}</span>
                                            <span class="total-amount">{{number_format(Helper::totalCartPrice())}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">{{ __('web.checkout') }}</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{ (Request::path()=='home') ? 'active' : ''}}"><a href="{{route('home')}}">{{ __('web.home') }}</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='products')  active  @endif"><a href="{{route('product-grids')}}">{{ __('web.product') }}</a></li>
                                            @php
                                                $categories = Helper::getAllCategory();
                                            @endphp
                                            <li>
                                                <a href="javascript:void(0);">{{ __('web.category') }}<i class="ti-angle-down"></i></a>
                                                <ul class="dropdown border-0 shadow">
                                                @foreach($categories as $key1 => $lv1)
                                                    @if($lv1->child_cat->count() > 0)
                                                        <li>
                                                            <a href="{{route('product-cat', $lv1->slug)}}">{{$lv1->title}}</a>
                                                            <ul class="dropdown sub-dropdown border-0 shadow">
                                                                @foreach($lv1->child_cat as $key2 => $lv2)
                                                                    @if($lv2->child_cat->count() > 0)
                                                                        <li>
                                                                            <a style="color: gray;" href="{{route('product-cat', $lv2->slug)}}">{{$lv2->title}}</a>
                                                                            <ul class="dropdown sub-dropdown border-0 shadow">
                                                                                @foreach($lv2->child_cat as $key3 => $lv3)
                                                                                    <li><a style="color: gray;"  href="{{route('product-cat', $lv3->slug)}}">{{$lv3->title}}</a></li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </li>
                                                                    @else
                                                                    <li><a style="color: gray;"  href="{{route('product-cat', $lv2->slug)}}">{{$lv2->title}}</a></li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li><a href="{{route('product-cat', $lv1->slug)}}">{{$lv1->title}}</a></li>
                                                    @endif
                                                @endforeach
                                                </ul>
                                            </li>

                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">{{ __('web.post') }}</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">{{ __('web.about') }}</a></li>
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">{{ __('web.contact') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>