@extends('frontend.layouts.master')

@section('title', __('web.cart'))

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{ route('home') }}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">{{ __('web.cart') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shopping Cart -->
<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (Helper::getAllProductFromCart()->count())
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th>{{ __('web.product') }}</th>
                            <th>{{ __('web.product_name') }}</th>
                            <th class="text-center">{{ __('web.product_price') }}</th>
                        </tr>
                    </thead>
                    <tbody id="cart_item_list">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            @foreach (Helper::getProductByBlog() as $brandBlock)
                            <tr>
                                <td colspan="2">
                                    <h4>{{ $brandBlock['brand']->title }} {{ $brandBlock['brand']->id }}</h4>
                                </td>
                                <td colspan="2" class="text-right">
      <a href="{{ route('cart.shop', ['brand_id' => $brandBlock['brand']->id]) }}" class="btn">{{ __('web.checkout') }}</a>
                                </td>
                            </tr>
                            @foreach ($brandBlock['products'] as $product)
                            <tr>
                                <td class="image" data-title="{{ __('web.product') }}"><img
                                        src="{{ $product->photo }}" alt="{{ $product->photo }}"></td>

                                <td class="product-des" data-title="{{ __('web.product_name') }}">
                                    <p class="product-name"><a
                                            href="{{ route('product-detail', $product->slug) }}"
                                            target="_blank">{{ $product->title }}</a></p>
                                </td>

                                <td class="price" data-title="{{ __('web.product_price') }}">
                                    <b>{{ number_format($product->price) }}</b>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            <track>
                            {{-- <td colspan="6" class="text-right">
                                <button class="btn" type="submit">{{ __('web.update') }}</button>
                            </td> --}}
                            </track>
                        </form>
                    </tbody>
                </table>
                <!--/ End Shopping Summery -->
                @else
                {{ __('web.cart_empty') }} <a href="{{ route('product-grids') }}">{{ __('web.continue_shopping') }}</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                {{-- @if (Helper::getAllProductFromCart()->count())
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form id="formCoupon" action="{{ route('coupon-store') }}" method="POST">
                                        @csrf
                                        <input name="code" placeholder="{{ __('web.enter_coupon') }}" required>
                                        <button class="btn">{{ __('web.apply') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                        {{ __('web.cart_subtotal') }}<span><b>{{ number_format(Helper::totalCartPrice()) }}
                                                VND</b></span></li>
                                    @if (session()->has('coupon'))
                                    <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">
                                        {{ __('web.your_save') }}<span><b>{{ number_format(Session::get('coupon')['value']) }}
                                                VND</b></span></li>
                                    @endif
                                    @php
                                    $total_amount = Helper::totalCartPrice();
                                    if (session()->has('coupon')) {
                                    $total_amount = $total_amount - Session::get('coupon')['value'];
                                    }
                                    @endphp
                                    @if (session()->has('coupon'))
                                    <li class="last" id="order_total_price">
                                        {{ __('web.your_pay') }}<span><b>{{ number_format($total_amount) }}
                                                VND</b></span></li>
                                    @else
                                    <li class="last" id="order_total_price">
                                        {{ __('web.your_pay') }}<span><b>{{ number_format($total_amount) }}
                                                VND</b></span></li>
                                    @endif
                                </ul>
                                <div class="button5">
                                    <a href="{{ route('checkout') }}" class="btn">{{ __('web.checkout') }}</a>
                                    <a href="{{ route('product-grids') }}"
                                        class="btn">{{ __('web.continue_shopping') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>
<!--/ End Shopping Cart -->
<!-- Start Shop Newsletter  -->
@include('frontend.layouts.newsletter')
<!-- End Shop Newsletter -->
@endsection

@push('styles')
<style>
    li.shipping{display:inline-flex;width:100%;font-size:14px}
li.shipping .input-group-icon{width:100%;margin-left:10px}
.input-group-icon .icon{position:absolute;left:20px;top:0;line-height:40px;z-index:3}
.form-select{height:30px;width:100%}
.form-select .nice-select{border:none;border-radius:0;height:40px;background:#f6f6f6!important;padding-left:45px;padding-right:40px;width:100%}
.list li{margin-bottom:0!important}
.list li:hover{background:#F7941D!important;color:#fff!important}
.form-select .nice-select::after{top:14px}
</style>
@endpush

@push('scripts')
<script>
    // JavaScript Code Here
</script>
@endpush
