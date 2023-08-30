@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.post_tag'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.post_tag') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-tag.update',$postTag->id)}}" id="formTag">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">{{ __('adm.name') }}</label>
          <input id="inputTitle" type="text" name="title" placeholder="{{ __('name') }}"  value="{{$postTag->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">{{ __('adm.status') }}</label>
          <select name="status" class="form-control">
            <option value="active" {{(($postTag->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
            <option value="inactive" {{(($postTag->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
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

@push('scripts')
<script>

$(document).ready(function() {

  $("#formTag").validate({
    rules: {
      title: {
        required: true,
      }
    },
  });
  
})
</script>

@endpush
