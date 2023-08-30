@extends('user.layouts.master')
@section('title', __('adm.dashboard'))
@section('main-content')
<div class="container-fluid">
    @include('user.layouts.notification')
    <!-- Page Heading -->
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <p class="h6 mb-0 text-gray-800">{{ __('adm.dashboard') }}</p>
    </div> -->

    <!-- Content Row -->
    @if(\Helper::isMobile())
    <div class="row">
      <div class="col-md-12">
        <p>Bạn đang truy cập trang web này bằng thiết bị Mobile, sử dụng Laptop hoặc PC để có trải nghiệm tốt hơn</p>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="mb-2">{{ __('adm.total_rollcall') }} <b class="text-success totalRollCall">{{ $totalRollCall ?? 0 }}</b></div>
                    <div class="mb-0 font-weight-bold ">
                      <button class="btn btn-sm btn-success btnRollCall">{{ __('adm.today') }}</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      @foreach($userWallets as $key => $balance)
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card wallet_{{ $balance->wallet_id }} shadow h-100 py-2">
          <div class="card-body">
            <a href="{{ route('user.wallet', $balance->wallet->id) }}" class="text-light">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $balance->wallet->name }}</div>
                  <div class="h5 mb-0 font-weight-bold value">
                    @if ($balance->wallet->is_token)
                      {{ number_format($balance->money ?? 0, 2) }}
                    @else
                      {{ number_format($balance->money ?? 0) }}
                    @endif
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
      @endforeach

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body p-2">
            <div class="row no-gutters align-items-center">
                <div class="col-6 text-center">
                  <p class="mb-2 pt-1">{{ __('adm.your_referrer') }} <b class="text-success">{{ $referrers->total() ?? 0 }}</b></p>
                  <span class="text-xs text-secondary">Chia sẻ nhiều - Nhận quà nhiều</span>
                </div>
                <div class="col-6 text-center pt-2">
                  {{ Helper::QrCodeReferrer(auth()->user()->id, 40) }}
                  <br>
                  <button class="btn btn-success btn-sm mt-1 copyAffiliate" data-link="{{ route('register.form', ['r' => Helper::setReferrer(auth()->user()->id)]) }}">{{ __('adm.copy') }}</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if (!empty($shop) && $shop->shop_admin == 1)
    <div class="row">
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <p class="m-0 font-weight-bold text-dark">{{ __('adm.order') }}</p>
          </div>
          <div class="card-body">
              <canvas id="countOrders"></canvas>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <p class="m-0 font-weight-bold text-dark">{{ __('adm.bonus_payment') }}</p>
          </div>
          <div class="card-body">
            <canvas id="commissions"></canvas>
          </div>
        </div>
      </div> 
    </div>
    @endif

    <div class="row">
      <!--<div class="col-xl-6 col-lg-6">-->
      <!--  <div class="card shadow mb-4">-->
      <!--    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">-->
      <!--      <p class="m-0 font-weight-bold text-dark">{{ __('adm.policy_rollcall_description') }}</p>-->
      <!--    </div>-->
      <!--    <div class="card-body">-->
      <!--      <div class="rollcall border rounded py-2 px-3">-->
      <!--        <p class="m-0">Nhận trực tiếp <b>10 VSN Coin</b></p>-->
      <!--        @foreach($policyRollCall['filia'] as $key => $filia)-->
      <!--          {{ $key }}<b class="ml-2 text-success">{{ $filia }}%</b> <br>-->
      <!--        @endforeach-->
      <!--      </div>-->
      <!--    </div>-->
      <!--  </div>-->
      <!--</div>-->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <p class="m-0 font-weight-bold text-dark">{{ __('adm.policy_seller_description') }}</p>
          </div>
          <div class="card-body">
            <div class="seller border rounded py-2 px-3">
              <p class="mb-0">Hoa hồng trên lợi nhuận sản phẩm</p>
              <p class="mb-0">Bán trực tiếp <b class="text-success">{{ $policySeller['direct'] }}%</b></p>
              @foreach($policySeller['filia'] as $key => $filia)
                {{ $key }}<b class="ml-2 text-success">{{ $filia }}%</b> <br>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </div>
@endsection

@push('scripts')
<script>
  // Revenue Order Chart
  if(document.getElementById("countOrders")){
    var countOrders = @json($countOrders);
    var ctx = document.getElementById('countOrders').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(countOrders),
            datasets: [{
                label: '# Số đơn hàng',
                data: Object.values(countOrders),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                      stepSize: 1
                    }
                }
            }
        }
    });
  }

  // New User Chart
  if(document.getElementById("commissions")){
    var commissions = @json($commissions);
    var ctx = document.getElementById('commissions').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(commissions),
            datasets: [{
                label: '# Hoa hồng (VNĐ)',
                data: Object.values(commissions),
                backgroundColor: [
                    'rgb(238, 130, 238)',
                ],
                borderColor: [
                    'rgb(238, 130, 238)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  }

  $('.btnRollCall').click(function() {
      $.ajax({
          url: "{{ route('user.rollcall.add') }}",
          type:"GET",
          dataType: 'json',
          success:function(res){
              swal("", res.message, "success");
              if(res.status) {
                  let total = $('.totalRollCall').text();
                  total = parseInt(total) + 1;
                  $('.totalRollCall').text(total);
              }
              if(res.token) {
                if($('.wallet_2 .value').length > 0) {
                  $('.wallet_2 .value').text(res.token);
                }
              }
          }
      });
    });
</script>
@endpush