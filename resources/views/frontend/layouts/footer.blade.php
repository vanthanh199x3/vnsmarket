@php
	$setting = \App\Models\Settings::first();
@endphp
<!-- Start Footer Area -->
<footer class="footer">
	<!-- Footer Top -->
	<div class="footer-top section">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer about">
						<div class="logo">
							<a href="/"><img width="200" src="{{$setting->logo}}" alt="logo"></a>
						</div>
						<p class="text">{{$setting->short_des}}</p>
						<p class="call">{{ __('web.call_us_now') }} 24/7<span><a href="tel:{{ preg_replace('/\D/', '', $setting->phone) ?? '' }}">{{$setting->phone}}</a></span></p>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					@php
						$pages = \App\Models\Page::where(['status' => 'active', 'type' => 1])->get();
					@endphp
					<div class="single-footer links">
						<h4>{{ __('web.link') }}</h4>
						<ul>
							<li><a href="{{route('contact')}}">{{ __('web.contact') }}</a></li>
							<li><a href="{{route('about-us')}}">{{ __('web.about') }}</a></li>
							@foreach($pages as $page)
								<li><a href="{{ route('page', $page->slug) }}">{{ $page->title }}</a></li>
							@endforeach
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					@php
						$pages = \App\Models\Page::where(['status' => 'active', 'type' => 2])->get();
					@endphp
					<div class="single-footer links">
						<h4>{{ __('web.customer_service') }}</h4>
						<ul>
							@foreach($pages as $page)
								<li><a href="{{ route('page', $page->slug) }}">{{ $page->title }}</a></li>
							@endforeach
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer social">
						<h4>{{ __('web.contact') }}</h4>
						<!-- Single Widget -->
						<div class="contact">
							<ul>
								<li>{{$setting->address}}</li>
								<li>
									<a href="mailto:{{$setting->email}}">{{$setting->email}}</a>
								</li>
								<li>
									<a href="tel:{{ preg_replace('/\D/', '', $setting->phone) ?? '' }}">{{$setting->phone}}</a>
								</li>
							</ul>
						</div>
						<!-- End Single Widget -->
						{{-- <div class="sharethis-inline-follow-buttons"></div> --}}
						<div class="follow-socials mt-4">
							@if($setting->facebook != '')
								<a href="{{ $setting->facebook }}" target="_blank" class="mr-1"><img src="{{asset('frontend/img/facebook.png')}}" width="30"></a>
							@endif
							@if($setting->zalo != '')
								<a href="{{ $setting->zalo }}" target="_blank" class="mr-1"><img src="{{asset('frontend/img/zalo.png')}}" width="30"></a>
							@endif
							@if($setting->youtube != '')
								<a href="{{ $setting->youtube }}" target="_blank" class="mr-1"><img src="{{asset('frontend/img/youtube.png')}}" width="30"></a>
							@endif
							@if($setting->instagram != '')
								<a href="{{ $setting->instagram }}" target="_blank" class="mr-1"><img src="{{asset('frontend/img/instagram.png')}}" width="30"></a>
							@endif
							@if($setting->tiktok != '')
								<a href="{{ $setting->tiktok }}" target="_blank" class="mr-1"><img src="{{asset('frontend/img/tiktok.png')}}" width="30"></a>
							@endif
						</div>
					</div>
					<!-- End Single Widget -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Footer Top -->
	<div class="copyright">
		<div class="container">
			<div class="inner">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="left">
							<p>Copyright © {{date('Y')}} <a href="/">{{ env('APP_NAME') }}</a>  -  All Rights Reserved.</p>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="right">
							<img src="{{asset('backend/img/payments.png')}}" alt="#">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- /End Footer Area -->

<!-- Jquery -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
<!-- Popper JS -->
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<!-- Bootstrap JS -->
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<!-- Slicknav JS -->
<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
<!-- Owl Carousel JS -->
<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
<!-- Nice Select JS -->
<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
<!-- Flex Slider JS -->
<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
<!-- ScrollUp JS -->
<script src="{{asset('frontend/js/scrollup.js')}}"></script>
<!-- Easing JS -->
<script src="{{asset('frontend/js/easing.js')}}"></script>
<script src="{{asset('frontend/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('frontend/js/additional-methods.min.js')}}"></script>
<script src="{{asset('frontend/js/messages_vi.js')}}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>

<!-- Active JS -->
<script src="{{mix('frontend/js/main.js')}}"></script>

<script>

setTimeout(function(){
	$('.alert').slideUp();
},5000);

$(function() {

	jQuery.validator.setDefaults({
		errorPlacement: function ( error, element ) {
			if(element.hasClass('select2') && element.next('.select2-container').length) {
			error.insertAfter(element.next('.select2-container'));
			} else if (element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			}
			else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
				error.insertAfter(element.parent().parent());
			}
			else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
				error.appendTo(element.parent().parent());
			}
			else {
				error.insertAfter(element);
			}
		}
	});

	$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
		event.preventDefault();
		event.stopPropagation();

		$(this).siblings().toggleClass("show");


		if (!$(this).next().hasClass('show')) {
		$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
		}
		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
		$('.dropdown-submenu .show').removeClass("show");
		});

	});
});
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y7M48LK4R0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Y7M48LK4R0');
</script>
@stack('scripts')