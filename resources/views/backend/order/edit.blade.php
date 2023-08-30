@extends('backend.layouts.master')
@section('title', __('adm.edit').' '.__('adm.order'))

@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.edit').' '.__('adm.order') }}</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->order_number)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group row">
       <div class="col-2">
        <label for="status">{{ __('adm.status') }} :</label>
        <select name="status" id="" class="form-control">
          <option value="new" {{($order->status=='delivered' || $order->status=="process" || $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='new')? 'selected' : '')}}>Mới</option>
          <option value="process" {{($order->status=='delivered'|| $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='process')? 'selected' : '')}}>Đang xử lý</option>
          <option value="delivered" {{($order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='delivered')? 'selected' : '')}}>Đã vận chuyển</option>
          <option value="cancel" {{($order->status=='delivered') ? 'disabled' : ''}}  {{(($order->status=='cancel')? 'selected' : '')}}>Hủy</option>
        </select>
       </div>
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
