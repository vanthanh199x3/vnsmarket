@extends('backend.layouts.master')
@section('title', __('adm.order'))

@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.order') }} 
    <!-- <a href="{{route('order.pdf',$order->order_number)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> {{ __('adm.generate_pdf') }}</a> -->
    <a class="btn btn-success float-right" href="{{ url()->previous() }}">{{ __('adm.return') }}</a>
  </h5>
  <div class="card-body">
    @if($order)
    <div class="table-responsive">
      <table class="table table-striped table-hover d-none">
        <thead class="thead-primary">
          <tr>
            <th>{{ __('adm.order_number') }}</th>
            <th>{{ __('adm.customer_name') }}</th>
            <th>{{ __('adm.customer_email') }}</th>
            <th>{{ __('adm.order_quantity') }}</th>
            <th>{{ __('adm.order_charge') }}</th>
            <th>{{ __('adm.total_amount') }}</th>
            <th>{{ __('adm.status') }}</th>
            <th>{{ __('adm.action') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>{{$order->order_number}}</td>
              <td>{{$order->full_name}}</td>
              <td>{{$order->email}}</td>
              <td>{{$order->quantity}}</td>
              <td>{{$order->shipping ? $order->shipping->price : ''}}</td>
              <td>{{number_format($order->total_amount,2)}}</td>
              <td>
                @if($order->status=='new')
                  <span class="badge badge-success">Mới</span>
                @elseif($order->status=='process')
                  <span class="badge badge-warning">Đang xử lý</span>
                @elseif($order->status=='delivered')
                  <span class="badge badge-primary">Đã vận chuyển</span>
                 @elseif($order->status=='logistics')
                  <span class="badge badge-primary">Đã chuyển logistics</span>
                @else
                  <span class="badge badge-danger">Hủy</span>
                @endif
              </td>
              <td>
                  <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                  <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                    @csrf
                    @method('delete')
                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                  </form>
              </td>

          </tr>
        </tbody>
      </table>

      <table class="table table-sm " id="product-dataTable" width="100%" cellspacing="0">
        <thead class="thead-primary">
          <tr>
            <th>{{ __('adm.photo') }}</th>
            <th>{{ __('adm.product_name') }}</th>
            <th>{{ __('adm.product_price') }}</th>
            <th>{{ __('adm.product_stock') }}</th>
            <th>{{ __('adm.total_amount') }}</th>
          </tr>
        </thead>
        <tbody>

          @foreach($order->cart as $cart)
            @php
              $product = $cart->product ?? NULL;
            @endphp
            @if ($product)
              <tr>
                <td>
                  @if($product->photo)
                      @php
                        $photo=explode(',',$product->photo);
                      @endphp
                      <a href="{{$product->photo}}" target="_blank"><img loading="lazy" src="{{$photo[0]}}" style="width:50px;height:50px" alt="{{$product->photo}}"/></a>
                  @else
                      <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                  @endif
                </td>
                <td>{{ Str::limit($product->title, 40, '...') }}</td>
                <td>{{ number_format($cart->price) }}</b></td>
                <td>{{$cart->quantity}}</td>
                <td>
                  <b class="text-success">{{ number_format($cart->amount) }}</b>
                </td>
              </tr>
            @else
              <tr>
                <td colspan="5">Sản phẩm đã bị xóa.</td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h6 class="text-center pb-4 text-uppercase">{{ __('adm.order_infomation') }}</h6>
              <table class="table">
                    <tr class="">
                        <td>{{ __('adm.order_number') }}</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.created_at') }}</td>
                        <td> : {{$order->created_at->format('Y-m-d H:i:s')}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.order_quantity') }}</td>
                        <td> : {{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.status') }}</td>
                        <td> : 
                          @if($order->status=='new')
                            Mới
                          @elseif($order->status=='process')
                            Đang xử lý
                          @elseif($order->status=='delivered')
                            Đã vận chuyển
                          @elseif($order->status=='logistics')
                            Đã chuyển logistics
                            
                          @else
                            Hủy
                          @endif
                        </td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.order_charge') }}</td>
                        <td> : {{ $order->shipping ? $order->shipping->price : '' }}</td>
                    </tr>
                    <tr>
                      <td>{{ __('adm.coupon') }}</td>
                      <td> : {{number_format($order->coupon)}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.total_amount') }}</td>
                        <td> : {{number_format($order->total_amount)}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.payment_method') }}</td>
                        <td> : @if($order->payment_method=='cod') {{ __('adm.cash_on_delivery') }} @else Paypal @endif</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.payment_status') }}</td>
                        <td> : 
                          @if($order->payment_status=='paid')
                            Đã thanh toán
                          @elseif($order->status=='unpad')
                            Chưa thanh toán
                          @else
                            Thanh toán thất bại
                          @endif
                        </td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h6 class="text-center pb-4 text-uppercase">{{ __('adm.shipping_infomation') }}</h6>
              <table class="table">
                    <tr class="">
                        <td>{{ __('adm.customer_name') }}</td>
                        {{-- <td> : {{$order->first_name}} {{$order->last_name}}</td> --}}
                        <td> : {{$order->full_name}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.customer_email') }}</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.customer_phone') }}</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('adm.customer_address') }}</td>
                        <td> : {{$order->address1}}, {{$order->address2}}</td>
                    </tr>
            
                    <!-- <tr>
                        <td>{{ __('adm.customer_country') }}</td>
                        <td> : {{$order->country}}</td>
                    </tr> -->
                    <!-- <tr>
                        <td>{{ __('adm.post_code') }}</td>
                        <td> : {{$order->post_code}}</td>
                    </tr> -->
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="text-center mt-4">
      <a href="{{route('order.edit',$order->order_number)}}" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit"></i> {{ __('adm.status') }}</a>
      <form method="POST" action="{{route('order.destroy',[$order->order_number])}}" class="d-inline-block">
        @csrf
        @method('delete')
            <button class="btn btn-danger btn-sm dltBtn"><i class="fas fa-trash-alt"></i> {{ __('adm.delete') }}</button>
      </form>
    </div>

    @endif
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

@push('scripts')
<script>
  $('.dltBtn').click(function(e){
    var form=$(this).closest('form');
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
</script>
@endpush
