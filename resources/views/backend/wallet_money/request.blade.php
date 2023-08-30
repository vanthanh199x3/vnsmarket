@extends('backend.layouts.master')
@section('title', __('adm.withdraw_request'))
@section('main-content')
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.withdraw_request') }}
    </div>
    <div class="card-body">
      <form action="" method="GET">
        <div class="row mb-3">
          <div class="col-3">
            <input type="text"  name="keyword" class="form-control" placeholder="Nhập email, mã giao dịch, số tiền ..." value="{{ request()->keyword }}">
          </div>
          <div class="col-2">
            <select name="status" class="form-control">
              <option value="">{{ __('adm.status') }}</option>
              <option value="1" {{ (( request()->status=='1') ? 'selected' : '') }}>Đã duyệt</option>
              <option value="0" {{ (( request()->status=='0') ? 'selected' : '') }}>Chưa duyệt</option>
            </select>
          </div>
          <div class="col-3">
            <button type="submit" class="btn btn-success">{{ __('adm.search_for') }}</button>
            <a href=""><button type="button" class="btn btn-info">{{ __('adm.reset') }}</button></a>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table table-sm" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
                <th scope="col">{{ __('adm.transaction_time') }}</th>
                <th scope="col">{{ __('adm.transaction_id') }}</th>
                <th scope="col">{{ __('adm.transaction_type') }}</th>
                <th scope="col">{{ __('adm.transfer_from') }}</th>
                <th scope="col">{{ __('adm.money') }}</th>
                <th scope="col">{{ __('adm.wallet') }}</th>
                <th scope="col">{{ __('adm.status') }}</th>
                <th scope="col">{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($requests))
            @foreach ($requests as $key => $item)
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
                      <span class="badge badge-warning">Rút tiền</span>
                    @endif
                </td>
                <td>
                  {{ $item->from_email }}
                </td>
                <td><b>{{ $item->from == auth()->user()->email ? '-' : '+' }} {{ number_format($item->money) }}</b></td>
                <td>{{ $item->wallet->name }}</td>
                <td>
                    @if($item->status == 1)
                        <span class="badge badge-success">Đã duyệt</span>
                    @else
                        <span class="badge badge-secondary">Chưa duyệt</span>
                    @endif
                </td>
                <td>
                  @if($item->status == 0)
                    <form method="POST" action="{{route('wallet.request',[$item->wallet->id])}}">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $item->transaction_id }}">
                        <button class="btn btn-sm btn-success btnApproved" data-bank="{{ json_encode($item->withdraᴡUserBank()) }}">Phê duyệt</button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="8"></td></tr>
          @endif
          </tbody>
        </table>
        <span style="float:right">{{ $requests->withQueryString()->links() }}</span>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.btnApproved').click(function(e) {
      var form = $(this).closest('form');
      var bank = JSON.parse($(this).attr('data-bank')) || {};
      var bankInfo = '';
      if (Object.keys(bank).length > 0) {
        bankInfo += '\n\nTên ngân hàng: ' + bank.bank_name;
        bankInfo += '\nChi nhánh: ' + bank.bank_address;
        bankInfo += '\nTên tài khoản: ' + bank.account_name;
        bankInfo += '\nSố tài khoản: ' + bank.account_number;
      }

      e.preventDefault();
      swal({
        title: "{{ __('adm.approved_withdraᴡ') }}",
        text: "{{ __('adm.approved_withdraᴡ_message') }}"+bankInfo,
        icon: "info",
        buttons: ["{{ __('adm.no') }}", "{{ __('adm.yes') }}"],
      })
      .then((ok) => {
        if (ok) {
          form.submit();
        }
      });
    })
</script>
@endpush