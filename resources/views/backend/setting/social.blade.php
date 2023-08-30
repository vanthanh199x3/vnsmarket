@extends('backend.layouts.master')
@section('title',__('adm.setting_social'))
@section('main-content')
<div class="mx-2">
  @include('backend.layouts.notification')
</div>
<div class="card mx-2">

  <h5 class="card-header">{{ __('adm.setting_social') }}</h5>
  <div class="card-body">
    <form method="post" action="{{route('setting.social')}}">
        @csrf 

        <div class="form-group">
          <label>Facebook</label>
          <input type="text" class="form-control" name="facebook" value="{{$data->facebook}}">
          @error('facebook')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label>Zalo</label>
          <input type="text" class="form-control" name="zalo" value="{{$data->zalo}}">
          @error('zalo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label>Instagram</label>
          <input type="text" class="form-control" name="instagram" value="{{$data->instagram}}">
          @error('instagram')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label>Youtube</label>
          <input type="text" class="form-control" name="youtube" value="{{$data->youtube}}">
          @error('youtube')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label>Tiktok</label>
          <input type="text" class="form-control" name="tiktok" value="{{$data->tiktok}}">
          @error('tiktok')
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