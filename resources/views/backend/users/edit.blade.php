@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.user'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.user') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}" id="formUser">
        @csrf 
        @method('PATCH')
        <div class="form-group row">
          <div class="col-6">
            <label for="inputTitle" class="col-form-label">{{ __('adm.user_fullname') }}</label>
            <input id="inputTitle" type="text" name="name" placeholder="{{ __('adm.user_fullname') }}"  value="{{$user->name}}" class="form-control">
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="inputEmail" class="col-form-label">{{ __('adm.email') }}</label>
            <input id="inputEmail" type="email" name="email" placeholder="{{ __('adm.email') }}"  value="{{$user->email}}" class="form-control">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">{{ __('adm.photo') }}</label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                  </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$user->photo}}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group row">
          <div class="col-6">
            <label for="role" class="col-form-label">{{ __('adm.user_role') }}</label>
              <select name="role" class="form-control">
                  <option value="">{{ __('adm.select') }}</option>
                  <option value="admin" {{ (($user->role=='admin') ? 'selected' : '') }}>Quản trị viên</option>
                  <option value="user" {{ (($user->role=='user') ? 'selected' : '') }}>Người dùng</option>
                  <option value="shop" {{ (($user->role=='shop') ? 'selected' : '') }}>Cửa hàng</option>

              </select>
              @error('role')
              <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
          <div class="col-6">
              <label for="status" class="col-form-label">{{ __('adm.status') }}</label>
              <select name="status" class="form-control">
                  <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>{{ __('adm.active') }}</option>
                  <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
              </select>
              @error('status')
              <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
        </div>
          <p class="mt-5 mb-0"><b>Thông tin xác minh</b></p>
          <div class="form-group row">
            @if($user->id_card_front != '')
            <div class="col-md-4">
              <label for="">CMND/CCCD mặt trước</label>
              <div class="border p-2 rounded text-center id_card_front">
                <img src="{{ asset('storage/'.$user->id_card_front) }}" height="200" class="rounded">
              </div>
            </div>
            @endif
            @if($user->id_card_back != '')
            <div class="col-md-4">
              <label for="">CMND/CCCD mặt sau</label>
              <div class="border p-2 rounded text-center id_card_back">
                <img src="{{ asset('storage/'.$user->id_card_back) }}" height="200" class="rounded">
              </div>
            </div>
            @endif
            @if($user->portrait != '')
            <div class="col-md-4">
              <label for="">Ảnh nhận dạng</label>
              <div class="border p-2 rounded text-center portrait">
                <img src="{{ asset('storage/'.$user->portrait) }}" height="200" class="rounded">
              </div>
            </div>
            @endif
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <label for="">Trạng thái xác minh</label>
              <select name="identifier" class="form-control">
                <option value="0" {{(($user->identifier==0) ? 'selected' : '')}}>Chưa xác minh</option>
                <option value="1" {{(($user->identifier==1) ? 'selected' : '')}}>Đã xác minh</option>
              </select>
            </div>
          </div>
        <div class="form-group mb-3">
           <button class="btn btn-success mt-4" type="submit">{{ __('adm.update') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#lfm').filemanager('image');

  $("#formUser").validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
      },
      password: {
        required: true,
      }
    },
  });
</script>
@endpush