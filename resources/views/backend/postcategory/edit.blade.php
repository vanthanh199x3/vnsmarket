@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.post_category'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.post_category') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-category.update',$postCategory->id)}}" id="formCategory">
        @csrf 
        @method('PATCH')

        <div class="form-group row">
          <div class="col-6">
            <label for="inputTitle" class="col-form-label">{{ __('adm.name') }}</label>
            <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.name') }}"  value="{{$postCategory->title}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="status" class="col-form-label">{{ __('adm.status') }}</label>
            <select name="status" class="form-control">
              <option value="active" {{(($postCategory->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
              <option value="inactive" {{(($postCategory->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
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

@push('scripts')
<script>

$(document).ready(function() {

  $("#formCategory").validate({
    rules: {
      title: {
        required: true,
      }
    },
  });
  
})
</script>

@endpush
