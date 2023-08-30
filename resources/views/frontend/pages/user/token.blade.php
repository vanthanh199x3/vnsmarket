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
							<li class="active"><a href="javascript:void(0);">Ví VNS</a></li>
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
                        @php $balance = $userWallets->where('wallet_id', 2)->first();  @endphp
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card wallet_{{ $balance->wallet_id }} shadow h-100 py-2">
                                    <div class="card-body py-1">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $balance->wallet->name }}</div>
                                            <div class="mb-0 font-weight-bold value">
                                                @if ($balance->wallet->is_token)
                                                {{ number_format($balance->money ?? 0, 2) }}
                                                @else
                                                {{ number_format($balance->money ?? 0) }}
                                                @endif
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-md-6 mb-4">
                                <p class="mb-2">Tham gia điểm danh để tích lũy VNS Token <span class="totalRollCall"></span></p>
                                <span  class="badge badge-success badge-pill p-2 btnRollCall" style="font-size: 16px;">Điểm danh ngay</span >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <form action="{{route('user.wallet.update', $balance->wallet_id)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Địa chỉ ví {{ $balance->wallet->name }}</label>
                                        </div>
                                        <div class="col-8 pr-0">
                                            <input type="text" name="wallet_address" class="form-control token-address" placeholder="Nhập địa chỉ ví" value="{{ $balance->wallet_address }}" autocomplete="off">
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-sm update-token-address">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
	</section>
@endsection

@push('styles')
<style>
    .card.wallet_1{
        color: #fff;
        border: 0;
        background-image: linear-gradient(to right, #0EBAA7, #E6DF44 );
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    }
    .card.wallet_1 .card-title{
        margin-bottom: 0;
        font-weight: 500;
    }
    .card.wallet_2{
        color: #fff;
        border: 0;
        background-image: linear-gradient(to right, #063852, #0EBAA7);
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    }
    .card.wallet_2 .card-title{
        margin-bottom: 0;
        font-weight: 500;
    }
    .btnRollCall{
        cursor: pointer;
    }
    .token-address{
        background: #e3e3e3;
        border-radius: 30px !important;
    }
    .update-token-address{
        text-transform: initial;
        height: 35px;
        padding: 6px 12px;
        border-radius: 30px !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $('.btnRollCall').click(function() {
        var _this = $(this);
        $.ajax({
            url: "user/rollcall/add",
            type:"GET",
            dataType: 'json',
            beforeSend: function() {
                _this.html('<i class="fa fa-spinner fa-spin"></i> Điểm danh ngay');
            },
            success:function(res){
                if(res.token) {
                    if($('.wallet_2 .value').length > 0) {
                        $('.wallet_2 .value').text(res.token);
                    }
                }
                setTimeout(function(){ alert(res.message); }, 500);
            },
            complete: function () {
                _this.html('Điểm danh ngay');
            }
        });
    });
</script>
@endpush
