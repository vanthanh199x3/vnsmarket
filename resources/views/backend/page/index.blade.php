@extends('backend.layouts.master')
@section('title', __('adm.page_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
      </div>
    <div class="card-header">
      {{ __('adm.page_list') }}
      <a href="{{route('page.create')}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.page') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($pages)>0)
        <table class="table table-sm" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.title') }}</th>
              <th>{{ __('adm.page_type') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $page)   
                <tr>
                  <td>{{$page->title}}</td>
                  <td>
                    @if($page->type == 1)
                      {{ __('adm.link') }}
                    @else
                      {{ __('adm.customer_service') }}
                    @endif
                  </td>
                  <td>
                      @if($page->status=='active')
                        <span class="badge badge-success">{{ __('adm.active') }}</span>
                      @else
                        <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                      @endif
                  </td>
                  <td>
                    <a href="{{route('page.edit', $page->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('page.destroy',[$page->id])}}">
                      @csrf 
                      @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$pages->links()}}</span>
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