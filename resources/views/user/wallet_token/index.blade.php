@extends('user.layouts.master')
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
    <div class="row">
      <div class="col-md-6">
        <form method="post" action="{{route('user.wallet.update', $userWallet->wallet_id)}}">
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
@endsection
