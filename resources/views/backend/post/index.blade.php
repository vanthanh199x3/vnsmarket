@extends('backend.layouts.master')
@section('title', __('adm.post_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.post_list') }}
      <a href="{{route('post.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.post') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.post') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($posts)>0)
        <table class="table table-sm" id="product-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.id') }}</th>
              <th>{{ __('adm.title') }}</th>
              <th>{{ __('adm.post_category') }}</th>
              <th>{{ __('adm.post_tag') }}</th>
              <th>{{ __('adm.post_author') }}</th>
              <th>{{ __('adm.photo') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
           
            @foreach($posts as $post)   
              @php 
              $author_info=DB::table('users')->select('name')->where('id',$post->added_by)->get();
              // dd($sub_cat_info);
              // dd($author_info);

              @endphp
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->cat_info->title}}</td>
                    <td>{{$post->tags}}</td>

                    <td>
                      @foreach($author_info as $data)
                          {{$data->name}}
                      @endforeach
                    </td>
                    <td>
                        @if($post->photo)
                            <img src="{{$post->photo}}" class="img-fluid zoom" style="max-width:80px" alt="{{$post->photo}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        @endif
                    </td>                   
                    <td>
                        @if($post->status=='active')
                          <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                          <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('post.edit',$post->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('post.destroy',[$post->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$post->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$posts->links()}}</span>
        @else
          <p class="text-center">{{ __('adm.no_result_found') }}</p>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <style>
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

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