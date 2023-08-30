@extends('backend.layouts.master')
@section('title', __('adm.banner_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.banner_list') }}
      <a href="{{route('banner.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.banner') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.banner') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($banners)>0)
        <table class="table table-sm " id="banner-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.id') }}</th>
              <th>{{ __('adm.title') }}</th>
              <th>{{ __('adm.slug') }}</th>
              <th>{{ __('adm.photo') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($banners as $banner)   
                <tr>
                    <td>{{$banner->id}}</td>
                    <td>{{$banner->title}}</td>
                    <td>{{$banner->slug}}</td>
                    <td>
                        @if($banner->photo)
                          <a href="{{$banner->photo}}" target="_blank"><img src="{{$banner->photo}}" loading="lazy" style="max-width:80px" alt="{{$banner->photo}}"></a>
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid zoom" style="max-width:100%" alt="avatar.png">
                        @endif
                    </td>
                    <td>
                        @if($banner->status=='active')
                          <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                          <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('banner.edit',$banner->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('banner.destroy',[$banner->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$banner->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$banners->links()}}</span>
        @else
          <p class="text-center">{{ __('adm.no_result_found') }}</p>
        @endif
      </div>
    </div>
</div>
@endsection


@push('scripts')

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  
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
              } else {
                  // swal("Your data is safe!");
              }
          });
      })
    })
  </script>
@endpush