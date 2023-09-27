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
							<li class="active"><a href="javascript:void(0);">Quản lý điểm</a></li>
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
                	 @if(session('success'))
		            <div class="message-success fade show mb-4">
		                {!! session('success') !!}
		            </div>
		            @endif
                        <p style="margin-bottom: 20px">Tổng Điểm VNSe hiện tại của bạn là {{$points->points}} VNSe</p>
                        <div class="clear"></div>
      <form method="post" action="{{route('user.transfer-points.submit')}}">
        {{csrf_field()}}
        <div class="form-group row">
           <div class="col-5">
            <label for="status" class="col-form-label"> Danh sách người mà bạn muốn chuyển điểm</label>
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
                </div>
            </div>
        </div>
	</section>
@endsection

<style type="text/css">
	.list
	{
		max-height: 300px;
	    overflow-y: auto !important;
	}
	.nice-select
	{
		display: block;
	    width: 100% !important;
	}
</style>