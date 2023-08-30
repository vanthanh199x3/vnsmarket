@extends('backend.layouts.master')
@section('title', __('adm.add').' '.__('adm.post_category'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.add').' '.__('adm.post_category') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-category.store')}}" id="formCategory">
        {{csrf_field()}}
        
        <div class="form-group row">
          <div class="col-6">
            <label for="inputTitle" class="col-form-label">{{ __('adm.name') }}</label>
            <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.name') }}"  value="{{old('title')}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="status" class="col-form-label">{{ __('adm.status') }}</label>
            <select name="status" class="form-control">
                <option value="active">{{ __('adm.active') }}</option>
                <option value="inactive">{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning mt-4">{{ __('adm.reset') }}</button>
           <button class="btn btn-success mt-4" type="submit">{{ __('adm.save') }}</button>
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
