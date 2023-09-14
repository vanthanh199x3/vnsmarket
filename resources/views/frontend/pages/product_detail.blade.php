@extends('frontend.layouts.master')
@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs d-none">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">{{ $product_detail->title }}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->


			
	<!-- Shop Single -->
	<section class="shop single section product-detail">
		<div class="container">

			@if(session('message'))
		    <div class="alertss">
		        {!! session('message') !!}
		    </div>
		   @endif
					
			<div class="row px-3 mt-3 justify-content-center"> 
				<div class="col-md-10 rounded pb-4 bg-white">
					<div class="row">
						<div class="col-lg-6 col-12">
							<!-- Product Slider -->
							<div class="product-gallery">
								<!-- Images slider -->
								<div class="flexslider-thumbnails">
									<ul class="slides">
										@php 
											$photo=explode(',',$product_detail->photo);
										@endphp
										@foreach($photo as $data)
											<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
												<img src="{{$data}}" alt="{{$data}}">
											</li>
										@endforeach
									</ul>
								</div>
								<!-- End Images slider -->
							</div>
							<!-- End Product slider -->
						</div>
						<div class="col-lg-6 col-12">
							<div class="product-des">
								<div class="short">
								 <input type="hidden" id="id_pro"  value="{{$product_detail->id}}"/>

									<h4>{{$product_detail->title}}</h4>
									<div class="rating-main">
										<ul class="rating">
											@php
												$rate=ceil($product_detail->getReview->avg('rate'))
											@endphp
												@for($i=1; $i<=5; $i++)
													@if($rate>=$i)
														<li><i class="fa fa-star"></i></li>
													@else 
														<li><i class="fa fa-star-o"></i></li>
													@endif
												@endfor
										</ul>
										<a href="#" class="total-review">{{ $product_detail['getReview']->count() }} {{ __('web.review') }}</a>
									</div>
									@php 
										$after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
									@endphp
									<p class="price" id="load_ajax_price_size">
										<span class="discount">{{number_format($after_discount)}} đ</span>
										<span class="text-danger"><b>- {{ $product_detail->discount }}%</b></span>
									</p>

<form action="{{route('single-add-to-cart')}}" method="POST">

  @if(isset($get_size_row->product_id) && !empty($get_size_row->size_price) && !empty($get_size_row->size_price_sale))
    <div class="radio-group">
        <div class="lable_size">Kích cỡ :</div>
        <div class="clear"></div>

        <div id="radio_check_size">
        	 @foreach ($get_size as $d_size)
			<input type="radio" name="check_size" value="{{ $d_size->id }}" /> {{ $d_size->size_name }}
			   @endforeach
		</div>
    </div><!--End radio-group-->
@else
    {{--  --}}
@endif  
                                

									<div class="price_token_box">
										<p class="price_token text-uppercase">{{ __('web.product_price_token') }} <span class="text-warning">{{number_format($product_detail->price_token,2)}}</span> {{ $product_detail->token_unit() }}</p>
										<p class="free_token text-uppercase">{{ __('web.free_token') }} <span class="text-warning">{{number_format($product_detail->free_token, 2)}}</span> {{ $product_detail->token_unit() }}</p>
									</div>
								</div>
								<div class="product-buy">

										@csrf 
										<div class="quantity">
											<!-- <h6 class="text-uppercase">{{ __('web.product_quantity') }} :</h6> -->
											<!-- Input Order -->
											<div class="input-group">
												<div class="button minus">
													<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
														<i class="ti-minus"></i>
													</button>
												</div>
												<input type="hidden" name="slug" value="{{$product_detail->slug}}">
												<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
												<div class="button plus">
													<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
														<i class="ti-plus"></i>
													</button>
												</div>
											</div>
										<!--/ End Input Order -->
										</div>
										<div class="add-to-cart mt-4">
											<button type="submit" class="btn">{{ __('web.add_to_cart') }}</button>
											<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a>
										</div>
									</form>


									<!-- <p class="availability text-uppercase">{{ __('web.stock') }} - @if($product_detail->stock>0)<b>{{$product_detail->stock}}</b>@else <span class="badge badge-danger">{{$product_detail->stock}}</span>  @endif</p> -->
									<p class="cat mt-4 mb-4">{{ __('web.category') }} - <a class="text-primary" href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a></p>
								</div>
								<div class="mt-3">
									@if(trim($product_detail->link_youtube) != '')
										<a href="{{ $product_detail->link_youtube }}" target="_blank" class="mr-2"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube" width="30"/></a>
									@endif
									@if(trim($product_detail->link_tiktok) != '')
										<a href="{{ $product_detail->link_tiktok }}" target="_blank" class="mr-2"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok" width="30"/></a>
									@endif
									@if(trim($product_detail->link_facebook) != '')
										<a href="{{ $product_detail->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook" width="30"/></a>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div style="border-top:1px solid #f1f1f1" class="mt-4"></div>
					<div class="row justify-content-center mx-1 rounded">
						@if(trim($product_detail->link_youtube) != '')
							<div class="col-sm-8 video_youtube" style="padding: 18px 30px;">
								<input type="hidden" value="{{ trim($product_detail->link_youtube) }}">
								<iframe allowfullscreen="1" style="width:100%;aspect-ratio:16/9;border-radius:7px;" frameborder="0" src=""></iframe>
							</div>
						@endif
						@if(trim($product_detail->link_tiktok) != '')
							<div class="col-sm-8 video_tiktok">
								<input type="hidden" name="video_tiktok" value="{{ trim($product_detail->link_tiktok) }}">
							</div>
						@endif
					</div>
				</div>
				<div class="col-md-10 mt-4 rounded bg-white">
					<div class="row pb-4">
						<div class="col-12">
							<div class="product-info">
								<div class="nav-main">
									<!-- Tab Nav -->
									<ul class="nav nav-tabs" id="myTab" role="tablist">
										<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">{{ __('web.description') }}</a></li>
										<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">{{ __('web.review') }}</a></li>
									</ul>
									<!--/ End Tab Nav -->
								</div>
								<div class="tab-content" id="myTabContent">
									<!-- Description Tab -->
									<div class="tab-pane fade show active" id="description" role="tabpanel">
										<div class="tab-single">
											<div class="row">
												<div class="col-12">
													<div class="description">
														{!!($product_detail->summary)!!}
													</div>
													<div class="single-des">
														<p>{!! ($product_detail->description) !!}</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--/ End Description Tab -->
									<!-- Reviews Tab -->
									<div class="tab-pane fade" id="reviews" role="tabpanel">
										<div class="tab-single review-panel">
											<div class="row">
												<div class="col-12">
													
													<!-- Review -->
													<div class="comment-review">
														<h4>{{ __('web.your_rating') }} <span class="text-danger">*</span></h4>
													<div class="review-inner">
													<!-- Form -->
													@auth
													<form class="form" method="post" action="{{route('review.store',$product_detail->slug)}}">
														@csrf
														<div class="row">
															<div class="col-lg-12 col-12">
																<div class="rating_box">
																		<div class="star-rating">
																		<div class="star-rating__wrap">
																			<input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
																			<input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
																			<input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
																			<input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
																			<input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
																			@error('rate')
																			<span class="text-danger">{{$message}}</span>
																			@enderror
																		</div>
																		</div>
																</div>
															</div>
															<div class="col-lg-12 col-12">
																<div class="form-group">
																	<label>{{ __('web.write_review') }}</label>
																	<textarea name="review" rows="6" placeholder="" ></textarea>
																</div>
															</div>
															<div class="col-lg-12 col-12">
																<div class="form-group button5">	
																	<button type="submit" class="btn">{{ __('web.submit') }}</button>
																</div>
															</div>
														</div>
													</form>
													@else 
													<p class="text-center p-5">
														{{ __('web.you_need_to') }} <a href="{{route('login.form')}}" style="color:rgb(54, 54, 204)">{{ __('web.login') }}</a> {{ __('web.or') }} <a style="color:blue" href="{{route('register.form')}}">{{ __('web.register') }}</a>

													</p>
													<!--/ End Form -->
													@endauth
														</div>
													</div>
												
													<div class="ratting-main">
														<div class="avg-ratting">
															<!-- <h6> {{ceil($product_detail->getReview->avg('rate'))}} <span>({{ __('web.total') }})</span></h6> -->
															<span>{!! __('web.total').' <b>'.ceil($product_detail->getReview->avg('rate')).' điểm</b> ('.__('web.base_on').' '.$product_detail->getReview->count().' '.__('web.comment').')' !!}</span>
														</div>
														@foreach($product_detail['getReview'] as $data)
														<!-- Single Rating -->
														<div class="single-rating">
															<div class="rating-author">
																@if($data->user_info['photo'])
																<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
																@else 
																<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
																@endif
															</div>
															<div class="rating-des">
																<h6>{{$data->user_info['name']}}</h6>
																<div class="ratings">

																	<ul class="rating">
																		@for($i=1; $i<=5; $i++)
																			@if($data->rate>=$i)
																				<li><i class="fa fa-star"></i></li>
																			@else 
																				<li><i class="fa fa-star-o"></i></li>
																			@endif
																		@endfor
																	</ul>
																	<div class="rate-count">(<span>{{$data->rate}}</span>)</div>
																</div>
																<p>{{$data->review}}</p>
															</div>
														</div>
														<!--/ End Single Rating -->
														@endforeach
													</div>
													
													<!--/ End Review -->
													
												</div>
											</div>
										</div>
									</div>
									<!--/ End Reviews Tab -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Shop Single -->
	
	<!-- Start Most Popular -->
	<div class="product-area most-popular related-product section bg-white pt-4">
        <div class="container">
            <div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>{{ __('web.related_product') }}</h2>
					</div>
				</div>
            </div>
            
            <div class="row">
                <div class="col-12 px-1">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_detail->rel_prods as $product)
                            @if($product->id !==$product_detail->id)
                                <!-- Start Single Product -->
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        @php
                                            $photo=explode(',',$product->photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                        {{-- <span class="out-of-stock">Hot</span> --}}
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
                                        </div>
                                        <div class="product-link">
                                            @if(trim($product->link_youtube) != '')
                                                <a href="{{ $product->link_youtube }}" target="_blank"><img src="{{asset('frontend/img/youtube.png')}}" alt="Youtube"/></a>
                                            @endif
                                            @if(trim($product->link_tiktok) != '')
                                                <a href="{{ $product->link_tiktok }}" target="_blank"><img src="{{asset('frontend/img/tiktok.png')}}" alt="Tiktok"/></a>
                                            @endif
                                            @if(trim($product->link_facebook) != '')
                                                <a href="{{ $product->link_facebook }}" target="_blank"><img src="{{asset('frontend/img/facebook.png')}}" alt="Facebook"/></a>
                                            @endif
                                        </div>
                                        <div class="product-action-2">
                                            <a href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                    <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                    
                                            @php
                                            $after_discount3=($product->price-($product->price*$product->discount)/100)
                                            @endphp
                                        
                                            <span class="product-price-token">{{ $product->price_token > 0 ? number_format($product->price_token) : '' }} {{ $product->token_unit() }}</span>
                                            <span class="product-price">{{number_format($after_discount3)}} VND</span>
                                            @if ($after_discount3 < $product->price)
                                                <span class="product-price-old">{{number_format($product->price)}} VND</del>
                                            @endif
                                </div>
                            </div>
                            <!-- End Single Product -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            
            
          
        </div>
    </div>
	<!-- End Most Popular Area -->

@endsection
@push('styles')
	<style>

		body{
			background-color: #f5f5fa;
		}
		/* Rating */
		.rating_box {
		display: inline-flex;
		}

		.star-rating {
		font-size: 0;
		padding-top: 10px;
		padding-right: 10px;
		}

		.star-rating__wrap {
		display: inline-block;
		font-size: 1rem;
		}

		.star-rating__wrap:after {
		content: "";
		display: table;
		clear: both;
		}

		.star-rating__ico {
		float: right;
		padding-left: 2px;
		cursor: pointer;
		color: #F7941D;
		font-size: 16px;
		margin-top: 5px;
		}

		.star-rating__ico:last-child {
		padding-left: 0;
		}

		.star-rating__input {
		display: none;
		}

		.star-rating__ico:hover:before,
		.star-rating__ico:hover ~ .star-rating__ico:before,
		.star-rating__input:checked ~ .star-rating__ico:before {
		content: "\F005";
		}

		/*	thanh dev	*/
		.radio-group {
		    position: relative;
		}
		.radio {
	    display: inline-block;
	    line-height: 30px;
	    margin-bottom: 15px;
	    margin-right: 10px;
	    border: 1px solid #dedede;
	    cursor: pointer;
	    width: 60px;
	    height: 30px;
	    text-align: center;
	    /* overflow: hidden; */
	}

	.radio.selected {
    border: 1px solid #25a8e0;
   }

.add-to-cart-success {
    cursor: default;
    position: absolute;
    background: #fff;
    box-shadow: 1px 1px 15px #b3b3b3;
    right: 60px;
    padding: 15px 20px;
    z-index: 9999;
    top: 7px;
    border-radius: 6px;
    left: auto;
}	.add-to-cart-success .close{opacity:.8;position:absolute;top:3px;right:5px;cursor:pointer;font-size:28px;line-height:1;color:#000;text-shadow:0 1px 0 #fff}
	.add-to-cart-success p.text{font-size:14px;color:#333;margin:0 10px 10px}
	.add-to-cart-success p.text i{color:#1db33f}
	.add-to-cart-success .btn{padding:8px 16px;margin:0 10px;background:#5ad3c0;color:#fff;font-size:14px;font-weight:200;border-radius:4px;text-align:center;border:0;cursor:pointer}
	.add-to-cart-success:after{content:"";position:absolute;width:11px;height:11px;top:-4px;right:15px;-webkit-transform:rotate(45deg);transform:rotate(45deg);background:#fff;box-shadow:-1px -1px 0 #dfdfdf;z-index:-1}

		/*	thanh dev	*/

	</style>
@endpush
@push('scripts')


<script>
	// thanh dev
	$(document).ready(function(){
	$('#radio_check_size input').on('change', function(e) {
      e.preventDefault();
    var get_id_size = $('input[name="check_size"]:checked', '#radio_check_size').val(); 
    var id_pro = $("#id_pro").val();

     $.ajax({
                    url:"<?=url('ajax_load_price_size');?>",
                    method : "GET",
                    data :{ get_id_size:get_id_size,id_pro:id_pro},
                    async: true,
                    dataType : 'json',
                    success: function(data){
                        $('#load_ajax_price_size').html(data.price_size);
                    }
                });
                return true;
});
	$(".close").click(function (event) {
		$(".add-to-cart-success").hide();
	});
}); 
		// thanh dev
	let tiktok_box=$(".video_tiktok"),tiktok_link=tiktok_box.find("input").val();""!=tiktok_link&&$.get("https://www.tiktok.com/oembed?url="+tiktok_link,function(t){t&&t.html&&tiktok_box.html(t.html)});let youtube_box=$(".video_youtube"),youtube_link=youtube_box.find("input").val();if(""!=youtube_link){var t=youtube_parser(youtube_link);t&&youtube_box.find("iframe").attr("src","https://www.youtube.com/embed/"+t)}function youtube_parser(t){var o=t.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/);return!!o&&11==o[7].length&&o[7]}
</script>
@endpush