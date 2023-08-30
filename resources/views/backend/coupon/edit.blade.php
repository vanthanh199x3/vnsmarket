@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.coupon'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.coupon') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('coupon.update',$coupon->id)}}" id="formCoupon">
        @csrf 
        @method('PATCH')

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">{{ __('adm.coupon_code') }} <span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="code" placeholder="{{ __('adm.coupon_code') }}"  value="{{$coupon->code}}" class="form-control">
              @error('code')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
      
            <div class="form-group">
              <label for="type" class="col-form-label">{{ __('adm.coupon_type') }} <span class="text-danger">*</span></label>
              <select name="type" class="form-control">
                  <option value="fixed" {{(($coupon->type=='fixed') ? 'selected' : '')}}>{{ __('adm.coupon_fixed') }}</option>
                  <option value="percent" {{(($coupon->type=='percent') ? 'selected' : '')}}>{{ __('adm.coupon_percent') }}</option>
              </select>
              @error('type')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
      
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">{{ __('adm.coupon_value') }} <span class="text-danger">*</span></label>
              <input id="inputTitle" type="number" name="value" placeholder="Enter Coupon value"  value="{{$coupon->value}}" class="form-control">
              @error('value')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
              
            <div class="form-group">
              <label for="status" class="col-form-label">{{ __('adm.status') }} <span class="text-danger">*</span></label>
              <select name="status" class="form-control">
                <option value="active" {{(($coupon->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
                <option value="inactive" {{(($coupon->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
              </select>
              @error('status')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success mt-4" type="submit">{{ __('adm.update') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $("#formCoupon").validate({
    rules: {
      code: {
        required: true,
      },
      type: {
        required: true,
      },
      value: {
        required: true,
        number: true
      }
    },
  });
});
</script>
@endpush