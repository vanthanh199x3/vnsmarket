@extends('frontend.layouts.master')

@section('title', config('app.name') . ' - ' . __('web.checkout'))

@section('main-content')



    <!-- Breadcrumbs -->

    <div class="breadcrumbs">

        <div class="container">

            <div class="row">

                <div class="col-12">

                    <div class="bread-inner">

                        <ul class="bread-list">

                            <li><a href="{{ route('home') }}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>

                            <li class="active"><a href="javascript:void(0)">{{ __('web.checkout') }}</a></li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- End Breadcrumbs -->



    <!-- Start Checkout -->

    <section class="shop checkout section">

        <div class="container">

            @if (Helper::getAllProductFromCart()->count())

                <form id="formOrder" class="form" method="POST" action="{{ route('cart.order') }}">

                    @csrf

                    <div class="row">

                        <div class="col-lg-8 col-12">

                            <div class="checkout-form">

                                <h2>{{ __('web.fill_payment_infor') }}</h2>

                                <p>{{ __('web.register_offer') }}</p>

                                <!-- Form -->

                                <input type="hidden" name="brand_id" value="{{ $brand_id }}">

                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.full_name') }}<span>*</span></label>

                                            <input type="text" name="full_name" placeholder=""

                                                value="{{ auth()->user()->name }}">

                                            @error('full_name')

                                                <span class='text-danger'>{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.email') }}<span>*</span></label>

                                            <input type="email" name="email" placeholder=""

                                                value="{{ auth()->user()->email }}">

                                            @error('email')

                                                <span class='text-danger'>{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.phone') }} <span>*</span></label>

                                            <input type="number" name="phone" placeholder="" required

                                                value="{{ auth()->user()->phone }}">

                                            @error('phone')

                                                <span class='text-danger'>{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>



                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.province') }}<span>(1)</span></label>

                                            <select name="province_id" id="province-select" class="select2"

                                                style="width:100%">

                                                <option value="">{{ __('web.select_province') }}</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.district') }}<span>(2)</span></label>

                                            <select name="district_id" id="district-select" class="select2"

                                                style="width:100%">

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.ward') }}<span>(3)</span></label>

                                            <select name="ward_id" id="ward-select" class="select2" style="width:100%">

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-lg-6 col-md-6 col-12">

                                        <div class="form-group">

                                            <label>{{ __('web.address_1') }}<span>*</span></label>

                                            <input id="address" type="text" name="address1" placeholder=""

                                                value="{{ auth()->user()->address }}">

                                            @error('address1')

                                                <span class='text-danger'>{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>



                                    <div class="col-lg-12 col-md-12 col-12" style="display: none;">

                                            <button type="button" onclick="checkFeeShip()"

                                                class="btn">Kiểm tra phí ship</button>

                                    </div>

                                </div>

                                <!--/ End Form -->

                            </div>

                        </div>

                        <div class="col-lg-4 col-12">

                            <div class="order-details">

                                <!-- Order Widget -->

                                <div class="single-widget">

                                    <h2>{{ __('web.product_total') }}</h2>

                                    <div class="content">

                                        @php

                                            $totalPrice = Helper::totalShopCartPrice($brand_id);

                                        @endphp

                                        <ul>

                                            <li class="order_subtotal" data-price="{{ $totalPrice }}">

                                                {{ __('web.cart_subtotal') }}<span><b>{{ number_format($totalPrice) }}

                                                        VND</b></span></li>

                                            <li class="shipping">

                                                {{ __('web.shipping_fee') }}

                                                @if (count(Helper::shipping()) > 0 && Helper::cartCount() > 0)

                                                    <select name="shipping" class="nice-select">

                                                        <option value="">{{ __('web.select_your_address') }}</option>

                                                        @foreach (Helper::shipping() as $shipping)

                                                            <option value="{{ $shipping->id }}" class="shippingOption"

                                                                data-price="{{ $shipping->price }}">{{ $shipping->type }}:

                                                                {{ $shipping->price }}</option>

                                                        @endforeach

                                                    </select>

                                                @else

                                                    <span id="fee-shop">23000</span>
                                                   

                                                @endif

                                            </li>



                                            @if (session('coupon'))

                                                <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">

                                                    {{ __('web.your_save') }}<span>{{ number_format(session('coupon')['value']) }}

                                                        VND</span></li>

                                            @endif

                                            @php

                                                
                                                $total_amount = $totalPrice+23000;

                                                if (session('coupon')) {

                                                    $total_amount = $total_amount - session('coupon')['value'];

                                                }

                                            @endphp

                                            <li class="last" id="order_total_price" data-money="{{ $total_amount }}">

                                                {{ __('web.cart_subtotal') }}<span><b>{{ number_format($total_amount) }}

                                                        VND</b></span></li>

                                        </ul>

                                    </div>

                                </div>

                                <!--/ End Order Widget -->

                                <!-- Order Widget -->

                                <div class="single-widget">

                                    <h2>{{ __('web.payment_method') }}</h2>

                                    <div class="content">

                                        <div class="checkbox">

                                            {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}

                                            <form-group>

                                                <input name="payment_method" id="pay_cod" checked type="radio"

                                                    value="cod"> <label for="pay_cod">

                                                    {{ __('web.cash_on_delivery') }}</label><br>

                                                <!-- <input name="payment_method" id="pay_paypal" type="radio" value="paypal"> <label for="pay_paypal"> Thanh toán PayPal</label><br> -->

                                                <input name="payment_method" id="pay_bank" type="radio"

                                                    value="bank"> <label for="pay_bank"> Thanh toán qua thẻ</label><br>

                                                {{-- <input name="payment_method" id="pay_vnspay"  type="radio" value="vnspay"> <label for="pay_vnspay"> Thanh toán bằng VNSPAY</label><br>  --}}

                                                <!-- <input name="payment_method" id="pay_token"  type="radio" value="token"> <label for="pay_token"> Thanh toán bằng Token</label> -->

                                            </form-group>

                                        </div>

                                        <div class="payment-info px-4 pt-2">

                                            @if (!empty($bank))

                                                <div

                                                    class="payment-info-item px-3 py-2 mx-3 bg-light border rounded pay_cod">

                                                    Bạn vui lòng chuẩn bị tiền mặt để thanh toán cho nhân viên khi nhận

                                                    hàng.

                                                </div>

                                                <div

                                                    class="payment-info-item px-3 py-2 mx-3 bg-light border rounded pay_paypal d-none">

                                                    Chức năng đang được phát triển

                                                </div>

                                                <div

                                                    class="payment-info-item px-3 py-2 mx-3 bg-light border rounded pay_bank d-none">

                                                    <p>Vui lòng chuyển khoản theo thông tin bên dưới, chúng tôi sẽ tiến hành

                                                        xử lý đơn hàng ngay sau khi nhận được thanh toán.</p>

                                                    <br>

                                                    <div style="text-align: center;">

                                                        <img width="150" src="{{ $bank->qr }}" style="">

                                                    </div>

                                                    <br>

                                                    <p><b>Thông tin tài khoản</b></p>

                                                    <p><b>Tên tài khoản:</b> {{ $bank->account_name }}</p>

                                                    <p><b>Số tài khoản:</b> {{ $bank->account_number }}</p>

                                                    <p><b>Tên ngân hàng:</b> {{ $bank->bank_name }}</p>

                                                    <p><b>Chi nhánh:</b> {{ $bank->bank_address }}</p>

                                                </div>

                                            @endif

                                            <div

                                                class="payment-info-item px-3 py-2 mx-3 bg-light border rounded pay_dsvpay d-none">

                                                <p>{{ __('web.balance') }}<b> VNSPAY</b></p>

                                                @if (Auth::check())

                                                    <p><b class="text-danger dsvpay_balance"

                                                            data-money="{{ $userWallet->money }}">{{ number_format($userWallet->money) }}</b>

                                                    </p>

                                                @else

                                                    <button class="btn btn-success">Đăng nhập</button>

                                                @endif

                                            </div>

                                            <div

                                                class="payment-info-item px-3 py-2 mx-3 bg-light border rounded pay_token d-none">

                                                <p>Địa chỉ ví</p>

                                                <p>827ccb0eea8a706c4c34a16891f84e7b</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!--/ End Order Widget -->

                                <!-- Payment Method Widget -->

                                <!-- <div class="single-widget payement">

                                                    <div class="content">

                                                        <img src="{{ 'backend/img/payment-method.png' }}" alt="#">

                                                    </div>

                                                </div> -->

                                <!--/ End Payment Method Widget -->

                                <!-- Button Widget -->

                                <div class="single-widget get-button">

                                    <div class="content">

                                        <div class="button">

                                            <button type="button"

                                                class="btn submitOrder">{{ __('web.proceed_to_checkout') }}</button>

                                        </div>

                                    </div>

                                </div>

                                <!--/ End Button Widget -->

                            </div>

                        </div>

                    </div>

                </form>

            @else

                {{ __('web.cart_empty') }} <a href="{{ route('product-grids') }}"

                    style="color:blue;">{{ __('web.continue_shopping') }}</a>

            @endif

        </div>

    </section>

    <!--/ End Checkout -->





    <!-- Start Shop Newsletter  -->

    @include('frontend.layouts.newsletter')

    <!-- End Shop Newsletter -->

@endsection

@push('styles')

    <style>

        li.shipping {

            display: inline-flex;

            width: 100%;

            font-size: 14px;

        }



        li.shipping .input-group-icon {

            width: 100%;

            margin-left: 10px;

        }



        .input-group-icon .icon {

            position: absolute;

            left: 20px;

            top: 0;

            line-height: 40px;

            z-index: 3;

        }



        .form-select {

            height: 30px;

            width: 100%;

        }



        .form-select .nice-select {

            border: none;

            border-radius: 0px;

            height: 40px;

            background: #f6f6f6 !important;

            padding-left: 45px;

            padding-right: 40px;

            width: 100%;

        }



        .list li {

            margin-bottom: 0 !important;

        }



        .list li:hover {

            background: #F7941D !important;

            color: white !important;

        }



        .form-select .nice-select::after {

            top: 14px;

        }

    </style>

@endpush

@push('scripts')

    <script>

        function checkAddress() {

            // Lấy giá trị của các trường

            var province = document.getElementById('province-select').value;

            var district = document.getElementById('district-select').value;

            var ward = document.getElementById('ward-select').value;

            var address = document.getElementsByName('address1')[0].value;



            // Kiểm tra xem tất cả các trường đã được điền hay chưa

            if (province && district && ward && address) {

                return true;

            }

            return false;

        }



        function checkFeeShip() {

            // Lấy giá trị của các trường

            var province = document.getElementById('province-select').value;

            var district = document.getElementById('district-select').value;

            var ward = document.getElementById('ward-select').value;

            var address = document.getElementsByName('address1')[0].value;



            // Kiểm tra xem tất cả các trường đã được điền hay chưa

            $check = false;

            if (province && district && ward && address) {

                $check = true;

            }



            if (!$check) {

                alert("Bạn phải nhập đủ thông tin để thanh toán");

            }

            else {

                var data = {

                    "shop_id": 460,

                    "weight": 2000,

                    "to_province": province,

                    "to_district": district,

                    "to_ward": ward

                };



                var jsonData = JSON.stringify(data);



                $.ajax({

                    url: "/api/check-fee-ship",

                    type: "POST",

                    headers: {

                        "Content-Type": "application/json",

                        "Access-Control-Allow-Origin": "*",

                        "Accept": "*/*"

                    },

                    data: jsonData,

                    success: function(response) {

                        var feeshop = $('#fee-shop');

                        feeshop.html(response);



                    }

                });

            }

        }



        $(document).ready(function() {

            // Lấy danh sách tỉnh thành từ API và điền vào select box

            $.ajax({

                url: '/api/address/provinces',

                type: 'GET',

                dataType: 'json',

                success: function(data) {

                    var select = $('#province-select');



                    $.each(data, function(key, value) {

                        select.append('<option value="' + value.name + '" data-code="' + value.code + '">' + value.name +

                            '</option>');

                    });

                }

            });



            // Gọi AJAX khi thay đổi giá trị của select tỉnh thành

            $('#province-select').on('change', function() {

                var provinceCode = $(this).find('option:selected').data('code');



                $.ajax({

                    url: '/api/address/districts/' + provinceCode,

                    type: 'GET',

                    dataType: 'json',

                    success: function(data) {

                        var select = $('#district-select');

                        var htmlText = "";

                        $.each(data, function(key, value) {

                            htmlText +='<option value="' + value.name + '" data-code="' + value.code + '">' + value

                                .name + '</option>';

                        });

                        select.html(htmlText);

                        $('#ward-select').html("");

                    }

                });

            });



            // Gọi AJAX khi thay đổi giá trị của select quận huyện

            $('#district-select').on('change', function() {

                var districtCode = $(this).find('option:selected').data('code');



                $.ajax({

                    url: '/api/address/wards/' + districtCode,

                    type: 'GET',

                    dataType: 'json',

                    success: function(data) {

                        var select = $('#ward-select');

                        var htmlText = "";

                        $.each(data, function(key, value) {

                            htmlText +='<option value="' + value.name + '">' + value

                                .name + '</option>';

                        });

                        select.html(htmlText);

                    }

                });

            });



            $('#ward-select').on('change', function() {

                var check = checkAddress();

            })



            $('#address').on('change', function() {

                var check = checkAddress();

            })

        });

    </script>

    <script>

        $(document).ready(function() {



            $("select.select2").select2();

            // $('select.nice-select').niceSelect();



            // $('.shipping select[name=shipping]').change(function(){

            //     let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;

            //     let subtotal = parseFloat( $('.order_subtotal').data('price') );

            //     let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;

            //     // alert(coupon);

            //     $('#order_total_price span').text((subtotal + cost-coupon).toFixed(2));

            // });



            $('input[name="payment_method"]').click(function() {

                $('.payment-info .payment-info-item').addClass('d-none');

                $('.payment-info .' + $(this).attr('id')).removeClass('d-none');

            })



            $("#formOrder").validate({

                rules: {

                    full_name: {

                        required: true,

                    },

                    email: {

                        required: true,

                        email: true,

                    },

                    phone: {

                        required: true,

                        number: true

                    },

                    province_id: {

                        required: true,

                    },

                    district_id: {

                        required: true,

                    },

                    ward_id: {

                        required: true,

                    },

                    address1: {

                        required: true,

                    },

                }

            });



            $('#formOrder .submitOrder').click(function() {



                if ($("#formOrder").valid()) {



                    var payment_method = $('input[name="payment_method"]:checked').val();

                    if (payment_method == 'dsvpay') {

                        console.log(payment_method)



                        if (confirm('Bạn có chắc muốn thanh toán thông qua ví DSVPAY')) {



                            var totalAmount = $('#order_total_price').attr('data-money');

                            var DSVPayBalance = $('.dsvpay_balance').attr('data-money');

                            if (parseInt(DSVPayBalance) < parseInt(totalAmount)) {

                                alert('Số dư trong ví DSVPAY không đủ, vui lòng nạp thêm!');

                                return;

                            } else {

                                $("#formOrder").submit();

                            }

                        }



                    } else {

                        $("#formOrder").submit();

                    }

                }

            });



        });



        // function showMe(box){

        //     var checkbox=document.getElementById('shipping').style.display;

        //     // alert(checkbox);

        //     var vis= 'none';

        //     if(checkbox=="none"){

        //         vis='block';

        //     }

        //     if(checkbox=="block"){

        //         vis="none";

        //     }

        //     document.getElementById(box).style.display=vis;

        // }

    </script>

@endpush

