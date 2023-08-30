@extends('user.layouts.master')
@section('title',__('adm.setting_layout'))
@section('main-content')
<div class="mx-2">
  @include('backend.layouts.notification')
</div>
<div class="card mx-2">

  <h5 class="card-header">{{ __('adm.setting_layout') }}</h5>
  <div class="card-body">
    <form method="post" action="{{route('shop.setting.layout')}}">
        @csrf 
        <div class="form-group">
          <label for="short_des" >{{ __('adm.short_description') }} <span class="text-danger">*</span></label>
          <textarea class="form-control" id="short_des" name="short_des" rows="5">{{$data->short_des}}</textarea>
          @error('short_des')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" >Shortcut <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="shortcut" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
          <input id="shortcut" class="form-control" type="text" name="shortcut" value="{{$data->shortcut}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('shortcut')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" >Logo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
          <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{$data->logo}}">
        </div>
        <div id="holder1" style="margin-top:15px;max-height:100px;"></div>
          @error('logo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="address" >{{ __('adm.address') }} <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="address" required value="{{$data->address}}">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email" >{{ __('adm.email') }} <span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" required value="{{$data->email}}">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone" >{{ __('adm.phone') }} <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="phone" required value="{{$data->phone}}">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="google_iframe">Google Map (Iframe)</label>
          <textarea class="form-control" id="google_iframe" name="google_iframe" rows="5">{{$data->google_iframe}}</textarea>
          @error('google_iframe')
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

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>

<script>
  $(document).ready(function() {

    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    
    $('#description').summernote({
      placeholder: "{{ __('adm.description') }}",
        tabsize: 2,
        height: 150
    });

  });
</script>
@endpush