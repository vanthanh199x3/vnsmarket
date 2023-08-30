@extends('backend.layouts.master')
@section('title', __('adm.add').' '.__('adm.post'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.add').' '.__('adm.post') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('post.store')}}" id="formPost">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">{{ __('adm.title') }} <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.title') }}"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="quote" class="col-form-label">{{ __('adm.post_quote') }}</label>
          <textarea class="form-control" id="quote" name="quote">{{old('quote')}}</textarea>
          @error('quote')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">{{ __('adm.summary') }} <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">{{ __('adm.description') }}</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group row">
          <div class="col-6">
            <label for="post_cat_id">{{ __('adm.post_category') }} <span class="text-danger">*</span></label>
            <select name="post_cat_id" class="form-control">
                <option value="">{{ __('adm.select') }}</option>
                @foreach($categories as $key=>$data)
                    <option value='{{$data->id}}'>{{$data->title}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-6">
            <label for="status">{{ __('adm.status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
                <option value="active">{{ __('adm.active') }}</option>
                <option value="inactive">{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <!-- <div class="form-group">
          <label for="tags">{{ __('adm.post_tag') }}</label>
          <select name="tags[]" multiple  data-live-search="true" class="form-control selectpicker">
              <option value="">{{ __('adm.select') }}</option>
              @foreach($tags as $key=>$data)
                  <option value='{{$data->title}}'>{{$data->title}}</option>
              @endforeach
          </select>
        </div> -->

        <!-- <div class="form-group">
          <label for="added_by">{{ __('adm.post_author') }}</label>
          <select name="added_by" class="form-control">
              <option value="">{{ __('adm.select') }}</option>
              @foreach($users as $key=>$data)
                <option value='{{$data->id}}' {{($key==0) ? 'selected' : ''}}>{{$data->name}}</option>
              @endforeach
              
          </select>
        </div> -->

        <input type="hidden" value="{{ auth()->user()->id }}" name="added_by">

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">{{ __('adm.photo') }} <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning mt-4">{{ __('adm.reset') }}</button>
          <button class="btn btn-success mt-4" type="submit">{{ __('adm.save') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  
$(document).ready(function() {
  
  $('#lfm').filemanager('image');

  $('#summary').summernote({
    placeholder: "{{ __('adm.description') }}",
      tabsize: 2,
      height: 100
  });

  $('#description').summernote({
    placeholder: "{{ __('adm.description') }}",
      tabsize: 2,
      height: 150
  });

  $('#quote').summernote({
    placeholder: "{{ __('adm.description') }}",
      tabsize: 2,
      height: 100
  });

  $("#formPost").validate({
    rules: {
      title: {
        required: true,
      },
      summary: {
        required: true,
      },
      post_cat_id: {
        required: true,
      }
    },
  });

});

</script>
@endpush