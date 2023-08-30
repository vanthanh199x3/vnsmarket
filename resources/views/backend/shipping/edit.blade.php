@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.shipping'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.shipping') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('shipping.update',$shipping->id)}}" id="formShipping">
        @csrf 
        @method('PATCH')
        <div class="form-group row">
          <div class="col-6">
            <label for="inputTitle" class="col-form-label">{{ __('adm.name') }} <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="type" placeholder="{{ __('adm.name') }}"  value="{{$shipping->type}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="price" class="col-form-label">{{ __('adm.shipping_fee') }} <span class="text-danger">*</span></label>
            <input id="price" type="number" name="price" placeholder="{{ __('adm.shipping_fee') }}"  value="{{$shipping->price}}" class="form-control">
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="status" class="col-form-label">{{ __('adm.status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active" {{(($shipping->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
              <option value="inactive" {{(($shipping->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
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

  $("#formShipping").validate({
    rules: {
      type: {
        required: true,
      },
      price: {
        required: true,
        number: true
      }
    },
  });
  
});
</script>
@endpush