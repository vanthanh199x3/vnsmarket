@extends('user.layouts.master')

@section('main-content')
<div class="mx-2">
  @include('backend.layouts.notification')
</div>
<div class="card mx-2">

  <h5 class="card-header">{{ __('adm.setting') }}</h5>
  <div class="card-body">
    <form method="post" action="{{route('shop.settings.update')}}">
        @csrf 
        {{-- @method('PATCH') --}}

        <p class="text-primary"><b>Thông tin chung</b></p>
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

        <p class="border-top text-primary mt-4 pt-3"><b>Trang giới thiệu</b></p>

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
        
        <p class="border-top text-primary mt-4 pt-3"><b>Liên kết mạng xã hội</b></p>

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
    $('#lfm2').filemanager('image');

    $('#description').summernote({
      placeholder: "{{ __('adm.description') }}",
        tabsize: 2,
        height: 150
    });

  });
</script>
@endpush