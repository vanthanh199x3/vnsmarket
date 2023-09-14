@extends('frontend.layouts.master')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">{{ __('web.contact') }}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if(session()->has('message'))
								<div class="alert alert-success">
									{{ session()->get('message') }}
								</div>
							@endif
							<div class="form-main">
								<div class="title">
									@php
										$setting = DB::table('settings')->first();
									@endphp
									<h4>{{ __('web.contact_form_title') }}</h4>
								</div>
								<form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
									@csrf
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>{{ __('web.full_name') }}<span>*</span></label>
												<input name="name" id="name" type="text" placeholder="{{ __('web.full_name') }}" value="{{ auth()->user()->name ?? '' }}">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>{{ __('web.subject') }}<span>*</span></label>
												<input name="subject" type="text" id="subject" placeholder="{{ __('web.subject') }}">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>{{ __('web.email') }}<span>*</span></label>
												<input name="email" type="email" id="email" placeholder="{{ __('web.email') }}" value="{{ auth()->user()->email ?? '' }}">
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>{{ __('web.phone') }}<span>*</span></label>
												<input id="phone" name="phone" type="number" placeholder="{{ __('web.phone') }}" value="{{ auth()->user()->phone ?? '' }}">
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group">
												<label>{{ __('web.your_message') }}<span>*</span></label>
												<textarea name="message" id="message" cols="30" rows="9" placeholder="{{ __('web.your_message') }}"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">{{ __('web.submit') }}</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">{{ __('web.call_us_now') }}:</h4>
									<ul>
										<li><a href="tel:{{ preg_replace('/\D/', '', $setting->phone) ?? '' }}">{{ $setting->phone }}</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">{{ __('web.email') }}:</h4>
									<ul>
										<li><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></li>
									</ul>
								</div>
								<div class="single-info">
									<a href="https://www.google.com/maps/place/125%2F53+Nguy%E1%BB%85n+V%C4%83n+Th%C6%B0%C6%A1ng,+Ph%C6%B0%E1%BB%9Dng+25,+B%C3%ACnh+Th%E1%BA%A1nh,+Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh,+Vi%E1%BB%87t+Nam/@10.8008437,106.715725,17z/data=!3m1!4b1!4m6!3m5!1s0x317528a66e6e4365:0xfae8f6c2f7e2d9ba!8m2!3d10.8008384!4d106.7182999!16s%2Fg%2F11c88h82k1?hl=vi-VN&entry=ttu" target="target"> <i class="fa fa-location-arrow"></i></a>
									<h4 class="title">{{ __('web.our_address') }}:</h4>
									<ul>
										<li>{{ $setting->address }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	<!-- Map Section -->
	<div class="map-section">
		<div id="myMap">
			@if($setting->google_iframe != '')
				{!! $setting->google_iframe !!}
			@endif
		</div>
	</div>
	<!--/ End Map Section -->
	
	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')

@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush

@push('scripts')
<script>
    $("#contactForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            subject: {
                required: true,
            },
            phone: {
                required: true,
            },
            message: {
                required : true,
            }
        }
    });
</script>
@endpush