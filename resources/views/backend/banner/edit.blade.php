@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.banner'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.banner') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('banner.update',$banner->id)}}" id="formBanner">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">{{ __('adm.title') }} <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$banner->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">{{ __('adm.description') }}</label>
          <textarea class="form-control" id="description" name="description">{{$banner->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">{{ __('adm.photo') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                </a>
            </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$banner->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group row">
          <div class="col-6">
            <label for="type">{{ __('adm.banner_type') }} <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-control">
                <option value="1"  {{$banner->type =='1' ? 'selected' : ''}}>{{ __('adm.banner_horizontal') }}</option>
                <option value="2"  {{$banner->type =='2' ? 'selected' : ''}}>{{ __('adm.banner_vertical') }}</option>
            </select>
          </div>
          <div class="col-6">
            <label for="status">{{ __('adm.status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active" {{(($banner->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
              <option value="inactive" {{(($banner->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success mt-4" type="submit">{{ __('adm.update') }}</button>
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
      
      $("#formBanner").validate({
        rules: {
          title: {
            required: true,
          },
          photo:{
            required: true
          }
        },
      });

      $('#description').summernote({
        placeholder: "{{ __('adm.description') }}",
          tabsize: 2,
          height: 150
      });
      
    });
</script>
@endpush