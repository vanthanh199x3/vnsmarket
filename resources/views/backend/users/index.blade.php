@extends('backend.layouts.master')
@section('title',__('adm.user_list'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.user_list') }}
      <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="{{ __('adm.add').' '.__('adm.user') }}"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.user') }}</a>
    </div>
    <div class="card-body">

      <form method="post" action="{{route('admin.transfer-points.submit')}}">
        {{csrf_field()}}
        <div class="form-group row">
           <div class="col-3">
            <label for="status" class="col-form-label">Danh sách user</label>
            <select name="receiver_id" class="form-control">
                @foreach($users as $user)   
                <option value="{{$user->id}}">{{$user->name}}</option>
                 @endforeach
            </select>
          </div>
          <div class="col-2">
            <label  class="col-form-label">Số điểm chuyển</label>
            <input  type="text" name="amount"   value="" class="form-control">
          </div>
    
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success mt-4" type="submit">Thực hiện</button>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table table-sm" id="user-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.user_fullname') }}</th>
              <th>Points</th>
              <th>{{ __('adm.email') }}</th>
              <th>{{ __('adm.shop') }}</th>
              <th>{{ __('adm.created_at') }}</th>
              <th>{{ __('adm.user_role') }}</th>
              <th>{{ __('adm.identifier') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th class="text-center">Điểm danh</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)   
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->points}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if ($user->role != 'admin')
                          @if(empty($user->shop))
                            <button class="btn btn-sm btn-light btn-shop">{{ __('adm.shop_not_create') }}</button>
                          @else
                            @if ($user->shop->status == 0)
                              <a href="{{ route('shop.info', $user->shop->id) }}" class="btn btn-sm btn-info btn-shop">{{ __('adm.not_approved') }}</a>
                            @elseif($user->shop->status == 1)
                              <a href="{{ route('shop.info', $user->shop->id) }}" class="btn btn-sm btn-success btn-shop">{{ $user->shop->shop_name }}</a>
                            @else
                            <a href="{{ route('shop.info', $user->shop->id) }}" class="btn btn-sm btn-danger btn-shop">{{ __('adm.deny') }}</a>
                            @endif
                          @endif
                        @endif
                    </td>
                    <td>{{(($user->created_at)? $user->created_at->diffForHumans() : '')}}</td>
                    <td>{{$user->role}}</td>
                    <td>
                      @if($user->identifier=='0')
                        <span class="badge badge-pill badge-secondary">Chưa xác minh</span>
                      @else
                        <span class="badge badge-pill badge-success">Đã xác minh</span>
                      @endif
                    </td>
                    <td>
                        @if($user->status=='active')
                            <span class="badge badge-success">{{ __('adm.active') }}</span>
                        @else
                            <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                      {{ $user->rollcall->count() }}
                    </td>
                    <td>
                      <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                      <form method="POST" action="{{route('users.destroy',[$user->id])}}" class="d-inline-block">
                        @csrf 
                        @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id="{{$user->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                      <button class="btn btn-sm btn-warning openTransferTokenModal" data-email="{{$user->email}}" style="height:30px; width:30px;border-radius:50%"><i class="fas fa-coins"></i></button>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$users->links()}}</span>
      </div>
    </div>
</div>

<div class="modal fade" id="transferTokenModal" tabindex="-1" role="dialog" aria-labelledby="transferTokenModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="transferTokenModal">Chuyển token</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Số lượng Token</label>
          <input type="number" class="form-control" name="money">
          <input type="hidden" name="transfer_to">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary btnTransfer">Chuyển</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .btn-shop {
    padding: 2px 6px;
    border-radius: 30px;
    font-size: 10px !important;
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

  $('.openTransferTokenModal').click(function() {
    var email = $(this).attr('data-email');
    $('#transferTokenModal input[name="transfer_to"]').val(email);
    $('#transferTokenModal input[name="money"]').val('');
    $('#transferTokenModal').modal('show');
  })

  $('.btnTransfer').click(function() {
    var transfer_to = $('#transferTokenModal input[name="transfer_to"]').val();
    var money = $('#transferTokenModal input[name="money"]').val();
    if (money != '') {
      $('#transferTokenModal').modal('hide');
      $.ajax({
          url: "{{ route('wallet.transfer', 2) }}",
          type:"POST",
          dataType: 'json',
          data: {transfer_to: transfer_to, money: money},
          success:function(res){
            swal("", res.message, "success");
          }
      });
    }
  })
</script>
@endpush