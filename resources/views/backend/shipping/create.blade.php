@extends('backend.layouts.master')
@section('title',__('adm.add').' '.__('adm.shipping'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.add').' '.__('adm.shipping') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('shipping.store')}}" id="formShipping">
        {{csrf_field()}}
        <div class="form-group row">
          <div class="col-4">
            <label for="inputTitle" class="col-form-label">{{ __('adm.name') }} <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="type" placeholder="{{ __('adm.name') }}"  value="{{old('type')}}" class="form-control">
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-4">
            <label for="price" class="col-form-label">{{ __('adm.shipping_fee') }} <span class="text-danger">*</span></label>
            <input id="price" type="number" name="price" placeholder="{{ __('adm.shipping_fee') }}"  value="{{old('price')}}" class="form-control">
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-4">
            <label for="status" class="col-form-label">{{ __('adm.status') }} <span class="text-danger">*</span></label>
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