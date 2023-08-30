@extends('backend.layouts.master')
@section('title', __('adm.review_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.review_list') }}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($reviews)>0)
        <table class="table table-sm" id="order-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.id') }}</th>
              <th>{{ __('adm.review_by') }}</th>
              <th>{{ __('adm.product_name') }}</th>
              <th>{{ __('adm.review_message') }}</th>
              <th>{{ __('adm.review_rate') }}</th>
              <th>{{ __('adm.created_at') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{$review->id}}</td>
                    <td>{{$review->user_info['name']}}</td>
                    <td>{{$review->product->title}}</td>
                    <td>{{$review->review}}</td>
                    <td>
                     <ul style="list-style:none">
                          @for($i=1; $i<=5;$i++)
                          @if($review->rate >=$i)
                            <li style="float:left;color:#F7941D;"><i class="fa fa-star"></i></li>
                          @else
                            <li style="float:left;color:#F7941D;"><i class="far fa-star"></i></li>
                          @endif
                        @endfor
                     </ul>
                    </td>
                    <td>{{$review->created_at}}</td>
                    <td>
                        @if($review->status=='active')
                          <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                          <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('review.edit',$review->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('review.destroy',[$review->id])}}">
                          @csrf
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$review->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$reviews->links()}}</span>
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
