@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.bank_account'))
@section('main-content')

<div class="card mx-2">
    <div class="row">
      <div class="col-md-12">
        @include('backend.layouts.notification')
      </div>
    </div>
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.bank_account') }}</h5>
    <div class="card-body">
      <form id="formBankInfo" method="post" action="{{route('bank.update')}}">
        @csrf 
        <input type="hidden" name="id" value="{{ $bank->id ?? '' }}">
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <label class="col-form-label">{{ __('adm.bank_name') }} <span class="text-danger">*</span></label>
              <input type="text" name="bank_name" placeholder="{{ __('adm.bank_name') }}"  value="{{$bank->bank_name ?? ''}}" class="form-control">
              @error('bank_name')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="col-form-label">{{ __('adm.bank_address') }} <span class="text-danger">*</span></label>
              <input type="text" name="bank_address" placeholder="{{ __('adm.bank_address') }}"  value="{{$bank->bank_address ?? ''}}" class="form-control">
              @error('bank_address')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="col-form-label">{{ __('adm.account_name') }} <span class="text-danger">*</span></label>
              <input type="text" name="account_name" placeholder="{{ __('adm.account_name') }}"  value="{{$bank->account_name ?? ''}}" class="form-control">
              @error('account_name')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="col-form-label">{{ __('adm.account_number') }} <span class="text-danger">*</span></label>
              <input type="text" name="account_number" placeholder="{{ __('adm.account_number') }}"  value="{{$bank->account_number ?? ''}}" class="form-control">
              @error('account_number')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="inputPhoto" >QR code <span class="text-danger">*</span></label>
              <div class="input-group">
                  <span class="input-group-btn">
                      <a id="lfm" data-input="qr" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                      </a>
                  </span>
                  <input id="qr" class="form-control" type="text" name="qr" value="{{$bank->qrcode}}">
                </div>
            </div>
            <div class="form-group">
              <label class="col-form-label">{{ __('adm.account_note') }}</label>
              <textarea name="note" class="form-control" rows="4" placeholder="{{ __('adm.account_note') }}">{{$bank->note ?? ''}}</textarea>
              @error('note')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            
            
          </div>
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">{{ __('adm.update') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>

  $('#lfm').filemanager('image');

  $("#formBankInfo").validate({
      rules: {
          bank_name: {
            required: true,
          },
          bank_address: {
            required: true,
          },
          account_name: {
            required: true,
          },
          account_number: {
            required: true,
          },
      }
  });

</script>
@endpush