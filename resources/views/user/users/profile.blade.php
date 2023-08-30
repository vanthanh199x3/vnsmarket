@extends('user.layouts.master')
@section('title',__('adm.profile'))
@section('main-content')

<div class="card shadow mb-4 mx-2">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
   <div class="card-header">
    {{ __('adm.profile') }}
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="image">
                        @if($profile->photo)
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{$profile->photo}}" alt="profile picture">
                        @else 
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                        @endif
                    </div>
                    <div class="card-body mt-4 ml-2">
                      <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->name}}</small></h5>
                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->email}}</small></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-8">
                <form id="formProfile" class="border rounded px-4 pt-2 pb-3" method="POST" action="{{ route('user.profile.update',$profile->id)}}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">{{ __('adm.user_fullname') }}</label>
                      <input id="inputTitle" type="text" name="name" placeholder="{{ __('adm.user_fullname') }}"  value="{{$profile->name}}" class="form-control">
                      @error('name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>
              
                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">{{ __('adm.email') }}</label>
                        <input id="inputEmail" disabled type="email" name="email" placeholder="{{ __('adm.email') }}"  value="{{$profile->email}}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">{{ __('adm.phone') }}</label>
                        <input type="text" name="phone" placeholder="{{ __('adm.phone') }}"  value="{{$profile->phone}}" class="form-control">
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="referrer" class="col-form-label">{{ __('adm.referrer_link') }}</label>
                            <input id="referrer" disabled placeholder="{{ __('adm.referrer_link') }}" value="{{$profile->parentReferrer->email ?? ''}}" class="form-control">
                            @error('referrer')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                
                      <div class="form-group">
                      <label for="inputPhoto" class="col-form-label">{{ __('adm.user_avatar') }}</label>
                      <div class="input-group">
                          <span class="input-group-btn">
                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                              </a>
                          </span>
                          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$profile->photo}}">
                      </div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                        <button type="submit" class="btn btn-success btn-sm mt-4">{{ __('adm.update') }}</button>
                </form>
            </div>
        </div>
   </div>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset("backend/img/background.jpg")}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style> 

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('backend/vendor/jquery-validate/messages_vi.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $("#formProfile").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50,
            },
            phone: {
                required: false,
                number: true
            },
        }
    });
</script>
@endpush