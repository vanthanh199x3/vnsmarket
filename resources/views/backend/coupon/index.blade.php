@extends('backend.layouts.master')
@section('title',__('adm.coupon_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.coupon_list') }}
      <a href="{{route('coupon.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.coupon') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.coupon') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($coupons)>0)
        <table class="table table-sm" id="banner-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.id') }}</th>
              <th>{{ __('adm.coupon_code') }}</th>
              <th>{{ __('adm.coupon_type') }}</th>
              <th>{{ __('adm.coupon_value') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($coupons as $coupon)   
                <tr>
                    <td>{{$coupon->id}}</td>
                    <td>{{$coupon->code}}</td>
                    <td>
                        @if($coupon->type=='fixed')
                            <span class="badge badge-primary">{{ __('adm.coupon_fixed') }}</span>
                        @else
                            <span class="badge badge-warning">{{ __('adm.coupon_percent') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($coupon->type=='fixed')
                          {{ number_format($coupon->value) }}
                        @else
                          {{$coupon->value}} %
                        @endif</td>
                    <td>
                      @if($coupon->status=='active')
                        <span class="badge badge-success">{{ __('adm.active') }}</span>
                      @else
                        <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                      @endif
                    </td>
                    <td>
                        <a href="{{route('coupon.edit',$coupon->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('coupon.destroy',[$coupon->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$coupon->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$coupons->links()}}</span>
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
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
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
  })
</script>
@endpush