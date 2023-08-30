@extends('backend.layouts.master')
@section('main-content')
<div class="card mx-2">
  <div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
  </div>
  <h5 class="card-header">{{ __('adm.message_list') }}</h5>
  <div class="card-body">
    @if(count($messages)>0)
    <div class="table-responsive">
      <table class="table tabme-sm table-sm message-table" id="message-dataTable">
        <thead class="thead-primary">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('adm.message_name') }}</th>
            <th scope="col">{{ __('adm.message_subject') }}</th>
            <th scope="col">{{ __('adm.message_time') }}</th>
            <th scope="col">{{ __('adm.action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ( $messages as $message)

          <tr class="@if($message->read_at) border-left-success @else bg-light border-left-warning @endif">
            <td scope="row">{{$loop->index +1}}</td>
            <td>{{$message->name}} {!! $message->read_at ? ' - <span class="text-xs text-muted">Đã xem</span>' : '' !!}</td>
            <td>{{$message->subject}}</td>
            <td>{{$message->created_at->format('F d, Y h:i A')}}</td>
            <td>
              <a href="{{route('message.show',$message->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
              <form method="POST" action="{{route('message.destroy',[$message->id])}}">
                @csrf 
                @method('delete')
                    <button class="btn btn-danger btn-sm dltBtn" data-id={{$message->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>

          @endforeach
        </tbody>
      </table>
    </div>
    <nav class="blog-pagination justify-content-center d-flex">
      {{$messages->links()}}
    </nav>
    @else
      <h2>{{ __('adm.no_result_found') }}</h2>
    @endif
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