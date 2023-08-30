@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.review'))
@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.edit').' '.__('adm.review') }}</h5>
  <div class="card-body">
    <form action="{{route('review.update',$review->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="name">{{ __('adm.review_by') }}:</label>
        <input type="text" disabled class="form-control" value="{{$review->user_info->name}}">
      </div>
      <div class="form-group">
        <label for="review">{{ __('adm.review_message') }}</label>
      <textarea name="review" id="" cols="20" rows="10" class="form-control">{{$review->review}}</textarea>
      </div>
      <div class="form-group">
        <label for="status">{{ __('adm.status') }} :</label>
        <select name="status" id="" class="form-control">
          <option value="">{{ __('adm.select') }}</option>
          <option value="active" {{(($review->status=='active')? 'selected' : '')}}>{{ __('adm.active') }}</option>
          <option value="inactive" {{(($review->status=='inactive')? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">{{ __('adm.update') }}</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }
</style>
@endpush