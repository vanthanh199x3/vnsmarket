@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.wallet'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.wallet') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('wallet.update', $wallet->id)}}" id="formWallet">
        {{csrf_field()}}
        @method('PATCH')
        <div class="form-group row">
          <div class="col-md-4">
            <label>{{ __('adm.name') }}</label>
            <input type="text" name="name" placeholder="{{ __('adm.name') }}"  value="{{ $wallet->name }}" class="form-control">
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label>{{ __('adm.is_token') }}</label>
            <select name="is_token" class="form-control">
              <option value="1" {{ $wallet->is_token == 1 ? 'selected' : '' }}>{{ __('adm.yes') }}</option>
              <option value="0" {{ $wallet->is_token == 0 ? 'selected' : '' }}>{{ __('adm.no') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="status">{{ __('adm.status') }}</label>
            <select name="status" class="form-control">
                <option value="1" {{ $wallet->status == 1 ? 'selected' : '' }}>{{ __('adm.active') }}</option>
                <option value="0" {{ $wallet->status == 0 ? 'selected' : '' }}>{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">{{ __('adm.reset') }}</button>
           <button class="btn btn-success" type="submit">{{ __('adm.save') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script>

$(document).ready(function() {

  $("#formWallet").validate({
    rules: {
      name: {
        required: true,
      }
    },
  });
  
})
</script>

@endpush

