@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.comment'))
@section('title','Comment Edit')

@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.edit').' '.__('adm.comment') }}</h5>
  <div class="card-body">
    <form action="{{route('comment.update',$comment->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="name">{{ __('adm.comment_author') }}:</label>
        <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
      </div>
      <div class="form-group">
        <label for="comment">{{ __('adm.comment_message') }}</label>
      <textarea name="comment" id="" cols="20" rows="10" class="form-control">{{$comment->comment}}</textarea>
      </div>
      <div class="form-group">
        <label for="status">{{ __('adm.status') }} :</label>
        <select name="status" id="" class="form-control">
          <option value="">{{ __('adm.select') }}</option>
          <option value="active" {{(($comment->status=='active')? 'selected' : '')}}>{{ __('adm.active') }}</option>
          <option value="inactive" {{(($comment->status=='inactive')? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
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