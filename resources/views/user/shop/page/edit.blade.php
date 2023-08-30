@extends('user.layouts.master')
@section('title', __('adm.edit').' '.__('adm.page'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.page') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('shop.page.update', $page->id)}}" id="formPage">
        @csrf 
        @method('PATCH')
        <div class="form-group row">
          <div class="col-md-4">
            <label for="inputTitle">{{ __('adm.title') }} <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$page->title}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="status">{{ __('adm.page_type') }} <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
                <option value="1" {{ (($page->type == '1') ? 'selected' : '')}}>{{ __('adm.link') }}</option>
                <option value="2" {{ (($page->type == '2') ? 'selected' : '')}}>{{ __('adm.customer_service') }}</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="status">{{ __('adm.status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active" {{(($page->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
              <option value="inactive" {{(($page->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">{{ __('adm.description') }}</label>
          <textarea class="form-control" id="description" name="description">{{$page->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
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
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
$(document).ready(function() {

  $("#formPage").validate({
    rules: {
      title: {
        required: true,
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