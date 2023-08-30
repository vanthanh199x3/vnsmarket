@extends('user.layouts.master')
@section('title', __('adm.product_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.product_list') }}
      <a href="{{route('shop.product.import')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.import').' '.__('adm.product') }}"><i class="fas fa-arrow-down"></i> {{ __('adm.import').' '.__('adm.product') }}</a>
      <a class="btn btn-sm btn-success float-right mr-2 importUpdate" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.update').' '.__('adm.product') }}"><i class="fas fa-sync"></i> {{ __('adm.update').' '.__('adm.product') }}</a>
    </div>
    <div class="card-body">

      <form action="" method="GET">
        <div class="row mb-3">
          <div class="col-3">
            <input type="text"  name="keyword" class="form-control" placeholder="{{ __('adm.product_name') }}" value="{{ request()->keyword }}">
          </div>
          <div class="col-3">
            <button type="submit" class="btn btn-success">{{ __('adm.search_for') }}</button>
            <a href="{{ route('shop.product.index') }}"><button type="button" class="btn btn-info">{{ __('adm.reset') }}</button></a>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        @if(count($products)>0)
        <p class="mb-1"><small>{{ $products->total() }} {{ __('adm.product') }}</small></p>
        <table class="table table-sm " id="product-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.photo') }}</th>
              <th>{{ __('adm.product_name') }}</th>
              <th>{{ __('adm.category') }}</th>
              <th>{{ __('adm.product_price') }}</th>
              <th>{{ __('adm.bonus') }}</th>
              <th>{{ __('adm.product_stock') }}</th>
              <th>{{ __('adm.updated_at') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>   
          <tbody>

            @foreach($products as $product)
                <tr>
                    <td>
                      @if($product->photo)
                          @php
                            $photo=explode(',',$product->photo);
                          @endphp
                          <!-- <img src="{{$photo[0]}}" class="img-fluid zoom" style="width:50px;height:50px" alt="{{$product->photo}}"> -->
                          <a href="{{$product->photo}}" target="_blank"><img loading="lazy" src="{{$photo[0]}}" style="width:50px;height:50px" alt="{{$product->photo}}"/></a>
                      @else
                          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                      @endif
                    </td>
                    <td>{{ Str::limit($product->title, 40, '...') }}</td>
                    <td>{{$product->cat_info['title']}}</td>
                    <td><b>{{ number_format($product->price) }}</b></td>
                    <td><b class="text-success">{{ number_format($product->bonus()) }}</b></td>
                    <td>
                      @if($product->stock>0)
                      <span class="badge badge-primary">{{ number_format($product->stock) }}</span>
                      @else
                      <span class="badge badge-danger">{{$product->stock}}</span>
                      @endif
                    </td>
                    <td>{{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                    <td>
                      @if ($product->is_import == 1)
                        <a href="{{route('shop.product.detail', $product->id)}}" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-info-circle"></i></a>
                      @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->withQueryString()->links()}}</span>
        @else
          <p class="text-center">{{ __('adm.no_result_found') }}</p>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <!-- <style>
      .zoom {
        transition: transform .2s;
      }
      .zoom:hover {
        transform: scale(5);
      }
  </style> -->
@endpush

@push('scripts')
<script>
$(document).ready(function(){
  $('.importUpdate').click(function() {
    $.ajax({
      url: "{{ route('shop.product.importUpdate') }}",
      method:"POST",
      dataType: 'json',
      success:function(res){
        swal("", res.message, res.success ? "success" : 'error');
        if (res.success) {
          setTimeout(function() {
            location.reload();
          }, 1000);
        }
      }
    });
  })
})
</script>
@endpush
