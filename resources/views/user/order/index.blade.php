@extends('user.layouts.master')
@section('title', __('adm.order_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.order_list') }}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-sm" id="order-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.order_number') }}</th>
              <th>{{ __('adm.created_at') }}</th>
              <th>{{ __('adm.customer_name') }}</th>
              <th>{{ __('adm.customer_phone') }}</th>
              <th>{{ __('adm.customer_email') }}</th>
              <th>{{ __('adm.total_amount') }}</th>
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
                  <td>{{$order->email}}</td>
                  <td><b>{{number_format($order->total_amount)}}</b></td>
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
                      <a href="{{route('user.order.show',$order->order_number)}}" class="btn btn-info btn-sm float-left mr-1">
                        {{ __('adm.view_detail') }}
                      </a>
                      <form method="POST" action="{{route('user.order.cancel',[$order->order_number])}}">
                        @csrf
                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->order_number}}>
                          {{ __('adm.cancel_order') }}
                        </button>
                      </form>
                  </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->links()}}</span>
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
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
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
                    }
                });
          })
      })
  </script>
@endpush
