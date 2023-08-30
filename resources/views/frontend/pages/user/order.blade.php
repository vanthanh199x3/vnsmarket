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
							<li class="active"><a href="javascript:void(0);">Đơn hàng đã mua</a></li>
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
                    <div class="bg-white p-4">
                        @if($orders->count())
                            @foreach ($orders as $order)
                                <div class="bg-light px-2 mb-1 rounded shadow-sm">
                                    #{{ $order->order_number }} - {{ number_format($order->total_amount) }} đ
                                </div>
                                @foreach($order->cart as $cart)
                                    <div class="row mt-2">
                                        <div class="col-md-1">
                                            <img src="{{ $cart->product->photo }}" height="100">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="text-dark mb-0"><small>{{ $cart->product->title }} x {{ $cart->quantity }}</small></p>
                                            <small>Giá bán: {{ number_format($cart->price) }} đ</small>
                                        </div>
                                        <div class="col-md-3"><small>Tổng cộng: {{ number_format($cart->amount) }} đ</small></div>
                                    </div>
                                @endforeach
                                <br>
                            @endforeach
                        @else
                            <p>Chưa có đơn hàng nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
	</section>
@endsection
