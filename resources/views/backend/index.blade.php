@extends('backend.layouts.master')
@section('title', __('adm.dashboard'))
@section('main-content')
    <div class="container-fluid">
        @include('backend.layouts.notification')
        <!-- Page Heading -->
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <p class="h5 mb-0 text-gray-800">{{ __('adm.dashboard') }}</p>
        </div> -->

        <!-- Content Row -->
        @if (\Helper::isMobile())
            <div class="row">
                <div class="col-md-12">
                    <p>Bạn đang truy cập trang web này bằng thiết bị Mobile, sử dụng Laptop hoặc PC để có trải nghiệm tốt
                        hơn</p>
                </div>
            </div>
        @endif

        <div class="row">
            {{-- <div class="col-xl-3 col-md-6 mb-4">
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
      </div> --}}

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card wallet_1 shadow h-100 py-2">
                    <div class="card-body">
                        <a href="#" class="text-light">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng doanh thu</div>
                                    <div class="h5 mb-0 font-weight-bold value">
                                        755,793,800
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @foreach ($userWallets as $key => $balance)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card wallet_{{ $balance->wallet_id }} shadow h-100 py-2">
                        <div class="card-body">
                            <a href="{{ route('wallet', $balance->wallet->id) }}" class="text-light">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ $balance->wallet->name }}</div>
                                        <div class="h5 mb-0 font-weight-bold value">
                                            @if ($balance->wallet->is_token)
                                                {{ number_format($balance->money ?? 0, 0) }}
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

            {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body p-2">
            <div class="row no-gutters align-items-center">
                <div class="col-6 text-center">
                  <p class="mb-2 pt-1">{{ __('adm.your_referrer') }} <b  class="text-success">{{ $referrers->total() ?? 0 }}</b></p>
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
      </div> --}}

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Shop con</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">81</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-2x text-gray-300 fa-store"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Số lượt điểm danh hôm nay</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $todayTotalRollCall }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-2x text-gray-300 fa-check"></i>
              </div>
            </div>
          </div>
        </div>
      </div> --}}


            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card wallet_1 shadow h-100 py-2">
                    <div class="card-body">
                        <a href="#" class="text-light">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Hoa hồng</div>
                                    <div class="h5 mb-0 font-weight-bold value">
                                        {{ number_format(183902506) }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Nhà cung cấp</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">39</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-2x text-gray-300 fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            {{-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    {{ __('adm.product') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Product::countActiveProduct() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Order -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('adm.order') }}
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{-- {{ \App\Models\Order::countActiveOrder() + 500 }} --}}
                                         1062</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    {{ __('adm.total_user') }}</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        {{-- <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{\App\User::countActiveUser()}}</div> --}}
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">880</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('adm.post') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Post::countActivePost()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-folder fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div> --}}
        </div>
    </div>

    <div class="row px-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <p class="m-0 font-weight-bold text-dark">{{ __('adm.revenue') }}</p>
                </div>
                <div class="card-body">
                    <canvas id="revenueOrders"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <p class="m-0 font-weight-bold text-dark">Số người đăng ký mới</p>
                </div>
                <div class="card-body">
                    <canvas id="newUsers"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row px-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <p class="m-0 font-weight-bold text-dark">{{ __('adm.policy_rollcall_description') }}</p>
                </div>
                <div class="card-body">
                    <div class="rollcall border rounded py-2 px-3">
                        @foreach ($policyRollCall['filia'] as $key => $filia)
                            {{ $key }}<b class="ml-2 text-success">{{ $filia }}%</b> <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <p class="m-0 font-weight-bold text-dark">{{ __('adm.policy_seller_description') }}</p>
                </div>
                <div class="card-body">
                    <div class="seller border rounded py-2 px-3">
                        <p class="mb-0">Hoa hồng trên lợi nhuận sản phẩm</p>
                        <p class="mb-0">Bán trực tiếp <b class="text-success">{{ $policySeller['direct'] }}%</b></p>
                        @foreach ($policySeller['filia'] as $key => $filia)
                            {{ $key }}<b class="ml-2 text-success">{{ $filia }}%</b> <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        // Revenue Order Chart
        var revenueOrders = @json($revenueOrders);
        var ctx = document.getElementById('revenueOrders').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(revenueOrders),
                datasets: [{
                    label: '# Doanh thu (VNĐ)',
                    data: Object.values(revenueOrders),
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
                    }
                }
            }
        });

        // New User Chart
        var newUsers = @json($newUsers);
        var ctx = document.getElementById('newUsers').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(newUsers),
                datasets: [{
                    label: '# Số người đăng ký mới',
                    data: Object.values(newUsers),
                    backgroundColor: [
                        'rgb(240,128,128)',
                    ],
                    borderColor: [
                        'rgb(205,92,92)',
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
    </script>
    <script>
        $('.btnRollCall').click(function() {
            $.ajax({
                url: "{{ route('rollcall.add') }}",
                type: "GET",
                dataType: 'json',
                success: function(res) {
                    swal("", res.message, "success");
                    if (res.status) {
                        let total = $('.totalRollCall').text();
                        total = parseInt(total) + 1;
                        $('.totalRollCall').text(total);
                    }
                    if (res.token) {
                        if ($('.wallet_2 .value').length > 0) {
                            $('.wallet_2 .value').text(res.token);
                        }
                    }
                }
            });
        });
    </script>
@endpush
