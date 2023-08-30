@extends('user.layouts.master')
@section('title', __('adm.wallet_money'))
@section('main-content')
<div class="card mx-2" id="wallet">
  <div class="row">
    <div class="col-md-12">
        @include('backend.layouts.notification')
    </div>
  </div>
  <h5 class="card-header">{{ __('adm.wallet_money') }}</h5>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-2">
        <div class="card wallet_{{ $userWallet->wallet_id }}" style="width: 14rem;">
          <div class="card-body">
            <h5 class="card-title">{{ number_format($userWallet->money ?? 0) }}</h5>
          </div>
        </div>
      </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Lịch sử giao dịch</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="recharge-tab" data-toggle="tab" href="#recharge" role="tab" aria-controls="recharge" aria-selected="false">Nạp tiền</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="ᴡithdraᴡ-tab" data-toggle="tab" href="#ᴡithdraᴡ" role="tab" aria-controls="ᴡithdraᴡ" aria-selected="false">Rút tiền</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="transfer-tab" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="false">Chuyển tiền</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
        <div class="row">
          <div class="col-md-12 pt-4">
            <div class="table-responsive">
              <table class="table table-sm">
                <thead class="thead-primary">
                  <tr>
                    <th scope="col">{{ __('adm.transaction_time') }}</th>
                    <th scope="col">{{ __('adm.transaction_id') }}</th>
                    <th scope="col">{{ __('adm.transaction_type') }}</th>
                    <th scope="col">{{ __('adm.transfer_from') }}</th>
                    <th scope="col">{{ __('adm.transfer_to') }}</th>
                    <th scope="col">{{ __('adm.money') }}</th>
                    <th scope="col">{{ __('adm.wallet') }}</th>
                    <th scope="col">{{ __('adm.status') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($histories))
                    @foreach ($histories as $key => $item)
                      <tr>
                        <td>{{ date('d/m/Y H:i:s', strtotime($item->transaction_time)) }}</td>
                        <td>{{ $item->transaction_id }}</td>
                        <td>
                          @if($item->transaction_type == 1)
                            Chuyển tiền
                          @elseif($item->transaction_type == 2)
                            Thanh toán đơn hàng
                          @elseif($item->transaction_type == 3)
                            Thanh toán hoa hồng
                          @elseif($item->transaction_type == 4)
                            Rút tiền
                          @endif
                        </td>
                        <td>
                          @if($item->from == auth()->user()->id)
                            <span class="text-primary">{{ $item->from_email }}</span>
                          @else
                            {{ $item->from_email }}
                          @endif
                        </td>
                        <td>
                          @if($item->to == auth()->user()->id)
                            <span class="text-primary">{{ $item->to_email }}</span>
                          @else
                            {{ $item->to_email }}
                          @endif
                        </td>
                        <td><b>{{ $item->from == auth()->user()->id ? '-' : '+' }} {{ number_format($item->money) }}</b></td>
                        <td>{{ $item->wallet->name }}</td>
                        <td>
                          @if($item->status == 1)
                            <span class="badge badge-success">Đã duyệt</span>
                          @else
                            <span class="badge badge-secondary">Chưa duyệt</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr><td colspan="8"></td></tr>
                  @endif
                </tbody>
              </table>
            </div>
            {!! $histories->links() !!}
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="recharge" role="tabpanel" aria-labelledby="recharge-tab">
        <div class="row mt-5">
          <div class="col-md-6 border rounded">
            <table class="table table-sm">
              <tbody>
                <tr>
                  <td colspan="2" class="border-0 text-uppercase text-success">
                    <b> Tài khoản ngân hàng</b>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="border-0 text-uppercase text-primary pb-2">
                    <img width="150" src="{{ asset('images/qrbank.png') }}">
                  </td>
                </tr>
                <tr>
                  <th scope="row">Số tài khoản</th>
                  <td>1761868888</td>
                </tr>
                <tr>
                  <th scope="row">Tên chủ tài khoản</th>
                  <td>CTY CP GIAI PHAP NEN TANG SO VIET NAM</td>
                </tr>
                <tr>
                  <th scope="row">Tên ngân hàng</th>
                  <td>Ngân hàng TMCP Á Châu</td>
                </tr>
                <tr>
                  <th scope="row">Chi nhánh</th>
                  <td>ACB- CN CU CHI</td>
                </tr>
                <tr>
                  <th scope="row">Nội dung chuyển tiền</th>
                  <td>NTDSVPAY {{ auth()->user()->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tr>
                <td colspan="2" class="border-0 text-uppercase text-success p-0 pl-1">
                  <b>Chú ý</b>
                </td>
              </tr>
              <tr>
                <td>
                  <ul class="pl-2">
                    <li>Bạn có thể chuyển bất kỳ số tiền muốn nạp.</li>
                    <li>Ghi rõ nội dung chuyển tiền "NTDSVPAY {{ auth()->user()->email }}"</li>
                    <li>Số dư của bạn sẽ tự động cập nhật khi hệ thống ngân hàng xác nhận.</li>
                    <li>Nếu bạn chuyển khác Ngân hàng, thời gian xác nhận có thể mất 24 giờ.</li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="ᴡithdraᴡ" role="tabpanel" aria-labelledby="ᴡithdraᴡ-tab">
        <div class="row mt-4">
          <div class="col-md-6">
            <form id="formWithdraᴡ" action="{{ route('user.wallet.ᴡithdraᴡ', 1) }}" method="POST">
              @csrf 
              <div class="form-group">
                <label for="transfer_to" class="col-form-label">{{ __('adm.money') }}</label>
                <input id="transfer_to" type="number" name="money" placeholder="{{ __('adm.money') }}"  value="{{old('money')}}" class="form-control">
                @error('money')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-sm btn-success" id="btnWithdraᴡ">{{ __('adm.ᴡithdraᴡ') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
        <div class="row mt-4">
          <div class="col-md-6">

            <form id="formTransfer" action="{{ route('user.wallet.transfer', 1) }}" method="POST">
              @csrf 
              <div class="form-group">
                <label for="transfer_to" class="col-form-label">{{ __('adm.transfer_to') }}</label>
                <input id="transfer_to" type="email" name="transfer_to" placeholder="{{ __('adm.transfer_to') }}"  value="{{old('transfer_to')}}" class="form-control">
                @error('transfer_to')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="money" class="col-form-label">{{ __('adm.money') }}</label>
                <input id="money" type="number" name="money" placeholder="{{ __('adm.money') }}"  value="{{old('money')}}" class="form-control">
                @error('money')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="content" class="col-form-label">{{ __('adm.transfer_content') }}</label>
                <textarea name="content" rows="4" class="form-control">{{old('content')}}</textarea>
                @error('content')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-sm btn-success" id="btnTransfer">{{ __('adm.transfer') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');

    var formTransfer = $("#formTransfer");
    formTransfer.validate({
        rules: {
          transfer_to: {
              required: true,
              email: true,
          },
          money: {
              required: true,
              number: true
          },
        }
    });

    $('#btnTransfer').click(function(){
      if(formTransfer.valid()) {
        swal({
          title: "{{ __('adm.confirm_tranfer') }}",
          text: "{{ __('adm.confirm_tranfer_message') }}" + formTransfer.find('input[name="transfer_to"]').val(),
          icon: "info",
          buttons: ["{{ __('adm.no') }}", "{{ __('adm.yes') }}"],
        })
        .then((ok) => {
          if (ok) {
            formTransfer.submit();
          }
        });
      }
    });

    var formWithdraᴡ = $("#formWithdraᴡ");
    var balance = parseInt('{{ $userWallet->money ?? 0 }}');
    formWithdraᴡ.validate({
        rules: {
          money: {
            required: true,
            number: true,
            min: 100000,
            max: balance,
          },
        }
    });

    $('#btnWithdraᴡ').click(function(){
      if(formWithdraᴡ.valid()) {
        swal({
          title: "{{ __('adm.confirm_withdraᴡ') }}",
          text: "{{ __('adm.confirm_withdraᴡ_message') }}",
          icon: "info",
          buttons: ["{{ __('adm.no') }}", "{{ __('adm.yes') }}"],
        })
        .then((ok) => {
          if (ok) {
            formWithdraᴡ.submit();
          }
        });
      }
    });

</script>
@endpush
