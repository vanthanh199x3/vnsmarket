@extends('backend.layouts.master')
@section('title', __('adm.product_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.product_list') }}
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.product') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.product') }}</a>
    </div>
    <div class="card-body">
      <form action="" method="GET">
        <div class="row mb-3">
          <div class="col-3">
            <input type="text"  name="keyword" class="form-control" placeholder="{{ __('adm.product_name') }}" value="{{ request()->keyword }}">
          </div>
          <div class="col-3">
            <button type="submit" class="btn btn-success">{{ __('adm.search_for') }}</button>
            <a href="{{ route('product.index') }}"><button type="button" class="btn btn-info">{{ __('adm.reset') }}</button></a>
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
              <th>{{ __('adm.product_import_price') }}</th>
              <th>{{ __('adm.product_price') }}</th>
              <!-- <th>{{ __('adm.product_discount') }}</th> -->
              <th>{{ __('adm.product_condition') }}</th>
              <!-- <th>{{ __('adm.brand') }}</th> -->
              <th>{{ __('adm.product_stock') }}</th>
              <th>{{ __('adm.status') }}</th>
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
                          <a href="{{$product->photo}}" target="_blank"><img loading="lazy" src="{{$photo[0]}}" style="width:50px;height:50px" alt="{{$product->photo}}"/></a>
                      @else
                          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                      @endif
                    </td>
                    <td>{{ Str::limit($product->title, 40, '...') }}</td>
                    <td>{{$product->cat_info['title']  ?? ""}}
                      <sub>
                          {{$product->sub_cat_info->title ?? ''}}
                      </sub>
                    </td>
                    <td><b>{{ number_format($product->import_price) }}</b></td>
                    <td><b class="text-success">{{ number_format($product->price) }}</b></td>
                    <!-- <td>  {{$product->discount}}% OFF</td> -->
                    <td>
                      @php
                        $conditions = ['new' => 'Mới', 'default' => 'Bình thường', 'hot' => 'Hot'];
                      @endphp
                      {{ $conditions[$product->condition] ?? '' }}
                    </td>
                    <!-- <td> {{ucfirst($product->brand->title ?? "")}}</td> -->
                    <td>
                      @if($product->stock>0)
                      <span class="badge badge-primary">{{ number_format($product->stock) }}</span>
                      @else
                      <span class="badge badge-danger">{{$product->stock}}</span>
                      @endif
                    </td>
                    <td>
                        @if($product->status=='active')
                            <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                            <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
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

@push('scripts')

  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                    } else {
                        //swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
