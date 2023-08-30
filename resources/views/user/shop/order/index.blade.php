@extends('user.layouts.master')
@section('title', __('adm.order_list'))
@section('main-content')
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      {{ __('adm.order_list') }}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <form action="" method="GET">
          <div class="row mb-3">
            <div class="col-4">
              <input name="keyword" class="form-control" placeholder="{{ __('adm.order_number').', '.__('adm.customer_name').', '.__('adm.customer_phone') }} ..." value="{{ request()->keyword }}">
            </div>
            <div class="col-2">
              <select name="status" class="form-control">
                <option value="">{{ __('adm.status') }}</option>
                <option value="new" {{(( request()->status=='new')? 'selected' : '')}}>Mới</option>
                <option value="process" {{(( request()->status=='process')? 'selected' : '')}}>Đang xử lý</option>
                <option value="delivered" {{((request()->status=='delivered')? 'selected' : '')}}>Đã vận chuyển</option>
                <option value="cancel" {{((request()->status=='cancel')? 'selected' : '')}}>Hủy</option>
              </select>
            </div>
            <div class="col-3">
              <button class="btn btn-success">{{ __('adm.search_for') }}</button>
              <a href="{{ route('order.index') }}"><button type="button" class="btn btn-info">{{ __('adm.reset') }}</button></a>
            </div>
          </div>
        </form>
        @if(count($orders)>0)
        <p class="mb-1"><small>{{ $orders->total() }} {{ __('adm.order') }}</small></p>
        <table class="table table-sm" id="order-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.order_number') }}</th>
              <th>{{ __('adm.created_at') }}</th>
              <th>{{ __('adm.customer_name') }}</th>
              <th>{{ __('adm.customer_phone') }}</th>
              <th>{{ __('adm.total_amount') }}</th>
              <th>{{ __('adm.bonus') }}</th>
              <th>{{ __('adm.bonus_payment') }}</th>
              <th>{{ __('adm.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)  
              <tr>
                <td>{{$order->order_number}}</td>
                <td class="text-muted">{{$order->created_at->format('d/m/Y H:i')}}</td>
                <td>{{$order->full_name}}</td>
                <td>{{$order->phone}}</td>
                <td><b>{{number_format($order->total_amount)}}</b></td>
                <td><b class="text-success">{{ number_format($order->bonus()) }}</b></td>
                <td>
                    @if ($order->bonus_status == '1')
                      <span class="badge badge-success">Đã thanh toán</span>
                    @else
                      <span class="badge badge-warning">Chưa thanh toán</span>
                    @endif
                </td>
                <td>
                  @if($order->status=='new')
                    <span class="badge badge-success">Mới</span>
                  @elseif($order->status=='process')
                    <span class="badge badge-warning">Đang xử lý</span>
                  @elseif($order->status=='delivered')
                    <span class="badge badge-primary">Đã vận chuyển</span>
                  @else
                    <span class="badge badge-danger">Hủy</span>
                  @endif
                </td>
              </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->withQueryString()->links()}}</span>
        @else
          <p class="text-center">{{ __('adm.no_result_found') }}</p>
        @endif
      </div>
    </div>
</div>
@endsection

@push('scripts')
  <script>
  </script>
@endpush