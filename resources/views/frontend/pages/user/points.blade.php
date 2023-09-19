@extends('frontend.layouts.master')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{ route('home') }}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Quản lý điểm</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	


	<section class="user-page section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 mt-4">
                    @include('frontend.pages.user.sidebar')
                </div>
                <div class="col-lg-9 col-12 mt-4">
                        <p>Tổng Điểm VNSe hiện tại của bạn là {{$points->points}} VNSe ≈ {{number_format($points->points*48)}} ₫ </p>
                </div>
            </div>
        </div>
	</section>
@endsection
