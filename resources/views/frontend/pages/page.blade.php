@extends('frontend.layouts.master')
@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">{{ $page->title }}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Page Content -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-12">
						<div class="page-content">
                            {!! $page->description !!}
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End Page Content -->

	@include('frontend.layouts.newsletter')
@endsection
