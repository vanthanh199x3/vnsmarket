@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.product_category'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.product_category') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('category.update',$category->id)}}" id="formCategory">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">{{ __('adm.name') }} <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.name') }}"  value="{{$category->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">{{ __('adm.summary') }}</label>
          <textarea class="form-control" id="summary" name="summary">{{$category->summary}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="is_parent">{{ __('adm.is_parent_category') }}</label><br>
          <input type="checkbox" name='is_parent' id='is_parent' value='{{$category->is_parent}}' {{(($category->is_parent==1)? 'checked' : '')}}> {{ __('adm.yes') }}                          
        </div>
        {{-- {{$parent_cats}} --}}
        {{-- {{$category}} --}}

      <div class="form-group {{(($category->is_parent==1) ? 'd-none' : '')}}" id='parent_cat_div'>
          <label for="parent_id">{{ __('adm.parent_category') }}</label>
          <select name="parent_id" class="form-control">
              <option value="">{{ __('adm.select') }}</option>
              @php 
                $prefix = [
                  1 => '',
                  2 => '\____',
                  3 => '\________',
                ]
              @endphp
              @foreach($parent_cats as $key=>$parent_cat)
                <option value='{{$parent_cat->id}}' {{(($parent_cat->id==$category->parent_id) ? 'selected' : '')}}>{{$parent_cat->title}}</option>
                @if($parent_cat->child_cat->count())
                  @foreach($parent_cat->child_cat as $lv2)
                  <option value='{{$lv2->id}}' {{(($lv2->id==$category->parent_id) ? 'selected' : '')}}>{{ $prefix[$lv2->level].' '.$lv2->title }}</option>
                  @endforeach
                @endif
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">{{ __('adm.photo') }}</label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$category->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">{{ __('adm.status') }} <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active" {{(($category->status=='active')? 'selected' : '')}}>{{ __('adm.active') }}</option>
              <option value="inactive" {{(($category->status=='inactive')? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
          </select>
          @error('status')
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

  $("#formCategory").validate({
    rules: {
      title: {
        required: true,
      }
    },
  });
  
  $('#summary').summernote({
    placeholder: "{{ __('adm.description') }}",
      tabsize: 2,
      height: 150
  });
});

$('#is_parent').change(function(){
  var is_checked=$('#is_parent').prop('checked');
  if(is_checked){
    $('#parent_cat_div').addClass('d-none');
    $('#parent_cat_div').val('');
  }
  else{
    $('#parent_cat_div').removeClass('d-none');
  }
})
</script>
@endpush