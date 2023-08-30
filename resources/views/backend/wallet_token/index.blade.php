@extends('backend.layouts.master')
@section('title',__('adm.wallet_token'))
@section('main-content')
<div class="card mx-2">
  <div class="row">
    <div class="col-md-12">
        @include('backend.layouts.notification')
    </div>
  </div>
  <h5 class="card-header">{{ __('adm.wallet_token') }}</h5>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-2">
        <div class="card wallet_{{ $userWallet->wallet_id }}" style="width: 14rem;">
          <div class="card-body">
            <h5 class="card-title">{{ number_format($userWallet->money ?? 0, 2) }}</h5>
          </div>
        </div>
      </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Lịch sử giao dịch</a>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link" id="transfer-tab" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="false">Chuyển tiền</a>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link" id="swap-tab" data-toggle="tab" href="#swap" role="tab" aria-controls="swap" aria-selected="false">Chuyển đổi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" id="connect-tab" data-toggle="tab" href="#connect" role="tab" aria-controls="connect" aria-selected="false">Kết nối</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
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
      <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
        <div class="row mt-4">
          <div class="col-md-6">

            <form id="formTransfer" action="{{ route('wallet.transfer', 1) }}" method="POST">
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
      <div class="tab-pane fade" id="swap" role="tabpanel" aria-labelledby="swap-tab">
        <div class="row mt-4">
          <div class="col-md-6">

            <form id="formTransfer" action="" method="POST">
              @csrf 
              <div class="form-group">
                <label for="transfer_to" class="col-form-label">{{ __('adm.swap_to') }}</label>
                <select name="swap" class="form-control">
                  @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                  @endforeach
                </select>
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
                <button type="button" class="btn btn-sm btn-success" id="btnSwap">{{ __('adm.swap') }}</button>
              </div>
            </form>

          </div>
        </div>
      </div>
      <div class="tab-pane fade show active" id="connect" role="tabpanel" aria-labelledby="connect-tab">
        <div class="row mt-4">
          <div class="col-md-6">
            <form method="post" action="{{route('wallet.update', $userWallet->wallet_id)}}">
              @csrf 
              <div class="form-group">
                <label for="">{{ __('adm.wallet_address') }}</label>
                <input type="hidden" name="wallet_id" value="{{ $userWallet->wallet_id ?? '' }}">
                <input type="text" name="wallet_address" class="form-control" value="{{ $userWallet->wallet_address ?? '' }}">
              </div>
              <div class="form-group">
                <button class="btn btn-success mt-2">{{ __('adm.update') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
