@extends('backend.layouts.master')
@section('title',__('adm.add').' '.__('adm.user'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.add').' '.__('adm.user') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}" id="formUser">
        {{csrf_field()}}
        <div class="form-group row">
          <div class="col-6">
            <label for="inputTitle" class="col-form-label">{{ __('adm.user_fullname') }}</label>
            <input id="inputTitle" type="text" name="name" placeholder="{{ __('adm.user_fullname') }}"  value="{{old('name')}}" class="form-control">
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="inputEmail" class="col-form-label">{{ __('adm.email') }}</label>
            <input id="inputEmail" type="email" name="email" placeholder="{{ __('adm.email') }}"  value="{{old('email')}}" class="form-control">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <label for="inputPassword" class="col-form-label">{{ __('adm.user_password') }}</label>
            <input id="inputPassword" type="password" name="password" placeholder="{{ __('adm.user_password') }}"  value="{{old('password')}}" class="form-control">
            @error('password')
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
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
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
                <option value="admin">Quản trị viên</option>
                <option value="user">Người dùng</option>
            </select>
            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-6">
            <label for="status" class="col-form-label">{{ __('adm.status') }}</label>
            <select name="status" class="form-control">
                <option value="active">{{ __('adm.active') }}</option>
                <option value="inactive">{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
            
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning mt-4">{{ __('adm.reset') }}</button>
           <button class="btn btn-success mt-4" type="submit">{{ __('adm.save') }}</button>
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