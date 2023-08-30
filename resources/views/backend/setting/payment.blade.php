@extends('backend.layouts.master')
@section('title',__('adm.setting_payment'))
@section('main-content')
<div class="mx-2">
  @include('backend.layouts.notification')
</div>
<div class="card mx-2">

  <h5 class="card-header">{{ __('adm.setting_payment') }}</h5>
  <div class="card-body">
    <form method="post" action="{{route('setting.payment')}}">
        @csrf 

        <div class="form-group">
          <label>{{ __('adm.default_wallet') }} <span class="text-danger">*</span></label>
          <select name="default_wallet" class="form-control">
            <option value="">{{ __('adm.select') }}</option>
            @foreach($admins as $admin)
              <option value="{{$admin->id}}" {{ $data->default_wallet == $admin->id ? 'selected' : '' }}>{{$admin->name}}</option>
            @endforeach
          </select>
          @error('default_wallet')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>{{ __('adm.default_bank') }} <span class="text-danger">*</span></label>
          <select name="default_bank" class="form-control">
            <option value="">{{ __('adm.select') }}</option>
            @foreach($admins as $admin)
              <option value="{{$admin->id}}" {{ $data->default_bank == $admin->id ? 'selected' : '' }}>{{$admin->name}}</option>
            @endforeach
          </select>
          @error('default_bank')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">{{ __('adm.update') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection
