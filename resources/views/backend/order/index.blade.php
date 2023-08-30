@extends('backend.layouts.master')
@section('title', __('adm.order_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      {{ __('adm.order_list') }}
    </div>
    <div class="card-body">
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
      <div class="table-responsive">
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
              <th>{{ __('adm.bonus_payment') }}</th>
              <th>{{ __('adm.shop') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                  <td>{{$order->order_number}}</td>
                  <td class="text-muted">{{$order->created_at->format('d/m/Y H:i')}}</td>
                  <td>{{$order->full_name}}</td>
                  <td>{{$order->phone}}</td>
                  <td>
                    <b>{{number_format($order->total_amount)}}</b>
                  </td>
                  <td>
                    <!-- <b class="text-success">{{number_format($order->bonus())}}</b> -->
                    @if($order->bonus_status == 0)
                      <span class="badge badge-warning approvedBonus" data-order-number="{{ $order->order_number }}" role="button">{{ __('adm.not_approved') }}</span>
                    @else
                      <span class="badge badge-success">{{ __('adm.approved') }}</span>
                    @endif
                  </td>
                  <td>
                    @if (!empty($order->shop))
                      <a target="_blank" class="text-info" href="{{ $order->shop->url() ?? ''}}"><i class="fas fa-home"></i> {{ $order->shop->shop_domain.'.'.$order->shop->base_domain ?? ''}}</a>
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
                  <td>
                      <a href="{{route('order.show',$order->order_number)}}" class="btn btn-warning btn-sm">{{ __('adm.view_detail') }}</a>
                      <a href="{{route('order.edit',$order->order_number)}}" class="btn btn-primary btn-sm">{{ __('adm.status') }}</a>
                      <!-- <form method="POST" action="{{route('order.destroy',[$order->order_number])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->order_number}}>{{ __('adm.delete') }}</button>
                      </form> -->
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
    $(document).ready(function(){
      
      $('.dltBtn').click(function(e){
        var form = $(this).closest('form');
        var dataID = $(this).data('id');
        e.preventDefault();
        swal({
            title: "{{ __('adm.confirm_delete') }}",
            text: "{{ __('adm.confirm_delete_message') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
              form.submit();
            } else {
              //swal("Your data is safe!");
            }
        });
      })

      $('.approvedBonus').click(function() {
        var _this = $(this);
        var orderNumber = $(this).attr('data-order-number');
        var shop = $(this).attr('data-shop');
        var bonus = $(this).attr('data-id');
        swal({
          title: "{{ __('adm.confirm_approved_bonus') }}",
          text: "{{ __('adm.confirm_approved_bonus_message') }}",
          icon: "info",
          buttons: ["{{ __('adm.no') }}", "{{ __('adm.yes') }}"],
          html: true
        })
        .then((ok) => {
          if (ok) {
            $.ajax({
              url: "{{ route('bonus.approved') }}",
              method:"POST",
              dataType: 'json',
              data: {orderNumber: orderNumber},
              success:function(res){
                swal("", 'success', 'Thanh toán hoa hồng thành công');
                _this.text('Đã duyệt');
                _this.removeClass('badge-warning');
                _this.addClass('badge-success');
              }
            });
          }
        });
      });

    })
  </script>
@endpush