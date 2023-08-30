@php
	$setting = DB::table('settings')->first();
@endphp
@extends('frontend.layouts.master')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{ route('home') }}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">{{ __('web.about') }}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							{{ __('web.welcome_to') }} <h3 class="ml-2 d-inline-block">{{ config('app.name') }}</h3>
							<p>{{ $setting->description }}</p>
							<div class="button">
								<!-- <a href="{{route('blog')}}" class="btn">{{ __('web.post') }}</a> -->
								<a href="{{route('contact')}}" class="btn primary">{{ __('web.contact') }}</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
							@if($setting->youtube_video != '')
								<div class="button">
									<a href="{{ $setting->youtube_video }}" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
								</div>
							@endif
							@if($setting->photo != '')
								<img src="{{ $setting->photo }}" alt="{{ config('app.name') }}">
							@endif
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->

	@include('frontend.layouts.newsletter')
@endsection
