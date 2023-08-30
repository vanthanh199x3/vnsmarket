@extends('backend.layouts.master')
@section('title', __('adm.post_category'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      {{ __('adm.post_category') }}
      <a href="{{route('post-category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.post_category') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.post_category') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($postCategories)>0)
        <table class="table table-sm" id="post-category-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.id') }}</th>
              <th>{{ __('adm.name') }}</th>
              <th>{{ __('adm.slug') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($postCategories as $data)   
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->title}}</td>
                    <td>{{$data->slug}}</td>
                    <td>
                        @if($data->status=='active')
                          <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                          <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('post-category.edit',$data->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('post-category.destroy',[$data->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$data->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$postCategories->links()}}</span>
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