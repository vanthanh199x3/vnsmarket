@extends('backend.layouts.master')
@section('title',__('adm.setting_introduce'))
@section('main-content')
<div class="mx-2">
  @include('backend.layouts.notification')
</div>
<div class="card mx-2">

  <h5 class="card-header">{{ __('adm.setting_introduce') }}</h5>
  <div class="card-body">
    <form method="post" action="{{route('setting.introduce')}}">
        @csrf
        <div class="form-group">
          <label for="inputPhoto" >Hình ảnh trang giới thiệu <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm2" data-input="thumbnail" data-preview="photo" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$data->photo}}">
        </div>
        <div id="photo" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="youtube_video">Youtube Video</label>
          <input type="text" class="form-control" name="youtube_video" id="youtube_video" value="{{ $data->youtube_video }}">
          @error('youtube_video')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" >Nội dung trang giới thiệu <span class="text-danger">*</span></label>
          <textarea class="form-control" id="description" name="description">{{$data->description}}</textarea>
          @error('description')
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

    $('#lfm2').filemanager('image');

    $('#description').summernote({
      placeholder: "{{ __('adm.description') }}",
        tabsize: 2,
        height: 150
    });

  });
</script>
@endpush