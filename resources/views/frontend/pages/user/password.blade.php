@extends('frontend.layouts.master')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{ route('home') }}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Đổi mật khẩu</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="user-page section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 mt-4">
                    @include('frontend.pages.user.sidebar')
                </div>
                <div class="col-lg-9 col-12 mt-4">
                    <form method="POST" action="{{ route('web.user.password') }}" class="bg-white p-4">
                        @csrf 
   
                        <div class="row mb-3">
                            <div class="col-4"></div>
                            <div class="col-6">
                                
                                @if ($errors->count())
                                    <div class="message-danger ">
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                    </div>
                                @endif

                                @if(session('message'))
                                    <div class="message-success">
                                        {!! session('message') !!}
                                    </div>
                                @endif
                           </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('adm.current_password') }}</label>
  
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('adm.new_password') }}</label>
  
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('adm.confirm_password') }}</label>
    
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            </div>
                        </div>
   
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('adm.change_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</section>
@endsection
