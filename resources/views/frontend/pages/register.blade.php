@extends('frontend.layouts.master')
@section('title', config('app.name').' - '. __('web.register'))
@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">{{ __('web.register') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>{{ __('web.register') }}</h2>
                        <p>{{ __('web.register_offer') }}</p>
                        <!-- Form -->
                        <form id="formRegister" class="form" method="post" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.full_name') }}<span>*</span></label>
                                        <input type="text" name="name" placeholder="" required="required" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.email') }}<span>*</span></label>
                                        <input type="text" name="email" placeholder="" required="required" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.phone') }}</label>
                                        <input type="text" name="phone" placeholder="" required="required" value="{{old('phone')}}">
                                        @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.password') }}<span>*</span></label>
                                        <input type="password" id="password" name="password" placeholder="" required="required" value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.confirm_password') }}<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="" required="required" value="{{old('password_confirmation')}}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('web.referrer_link') }}</label>
                                        <input type="text" name="referrer" placeholder="" value="{{ $affiliateEmail != '' ? $affiliateEmail : old('referrer')}}">
                                        @error('referrer')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">{{ __('web.register') }}</button>
                                        <a href="{{route('login.form')}}" class="btn">{{ __('web.login') }}</a>
                                        @if (request()->getHttpHost() == 'vnsmarket.vn')
                                            {{ __('web.or') }}
                                            <a href="{{route('login.redirect','facebook')}}" class="btn btn-facebook"><i class="ti-facebook"></i></a>
                                            <a href="{{route('login.redirect','google')}}" class="btn btn-google"><i class="ti-google"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection

@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $("#formRegister").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: false,
                number: true
            },
            password: {
                required: true,
                minlength: 2
            },
            password_confirmation: {
                equalTo : "#password"
            }
        }
    });
</script>
@endpush