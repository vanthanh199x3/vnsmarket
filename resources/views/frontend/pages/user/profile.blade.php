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
							<li class="active"><a href="javascript:void(0);">Thông tin cá nhân</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="card align-items-center text-center py-4" style=" background: transparent; ">
	    <div class="col-xl-8 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col-6 text-center">
                      <span class="text-xs text-secondary">Chia sẻ nhiều - Nhận quà nhiều</span>
                    </div>
                    <div class="col-6 text-center pt-2">
                      {{ Helper::QrCodeReferrer(auth()->user()->id, 100) }}
                      <br>
                      <button class="btn btn-success btn-sm mt-1 copyAffiliate" data-link="{{ route('register.form', ['r' => Helper::setReferrer(auth()->user()->id)]) }}">{{ __('adm.copy') }}</button>
                    </div>
                </div>
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
                    <form id="formProfile" class="bg-white p-4" method="POST" action="{{ route('web.user.profile', $profile->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('adm.user_fullname') }}</label>
                                    <input type="text" name="name" placeholder="{{ __('adm.user_fullname') }}"  value="{{$profile->name}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('adm.phone') }}</label>
                                    <input type="text" name="phone" placeholder="{{ __('adm.phone') }}" value="{{$profile->phone}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('adm.email') }} <small class="text-muted">(Không thể thay đổi)</small> </label>
                                    <input disabled type="email" name="email" placeholder="{{ __('adm.email') }}"  value="{{$profile->email}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('adm.address') }}</label>
                                    <input type="text" name="address" placeholder="{{ __('adm.address') }}"  value="{{$profile->address}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr class="mt-5">
                        @if ($profile->identifier == 0)
                            <span class="badge badge-pill badge-secondary mb-3 p-2">Chưa xác minh</span>

                            <h6>Xác minh danh tính</h6>
                            <p>Sau khi xác minh danh tính, bạn sẽ được tham gia các chương tình tích điểm VNS Coin.</p>
                            <div class="form-group mt-3">
                                <label for="">Mặt trước CCCD</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="id_card_front" name="id_card_front">
                                    <label class="custom-file-label" for="id_card_front">Chưa chọn</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Mặt sau CCCD</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="id_card_back" name="id_card_back">
                                    <label class="custom-file-label" for="id_card_back">Chưa chọn</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Ảnh chân dung</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="portrait" name="portrait">
                                    <label class="custom-file-label" for="portrait">Chưa chọn</label>
                                </div>
                            </div>
                        @else
                            <span class="badge badge-pill badge-success mb-3 p-2">Đã xác minh</span>
                            <p>Thông tin của bạn đã được bảo mật.</p>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('adm.update') }}</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
	</section>
@endsection
@push('scripts')
<script>
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('.copyAffiliate').click(function() {
        var link = $(this).attr('data-link');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(link).select();
        document.execCommand("copy");
        $temp.remove();

        swal("", '{{ __("adm.copy_success") }}', "success");

      })
</script>
@endpush