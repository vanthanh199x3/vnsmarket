@extends('frontend.layouts.master')
@section('title', config('app.name').' - '. __('web.product_list'))
@section('main-content')
	
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="javascript:void(0);">{{ __('web.product_list') }}</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
		<form action="{{route('shop.filter')}}" method="POST">
		@csrf
			<!-- Product Style 1 -->
			<section class="product-area shop-sidebar shop-list shop section">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-4 col-12">
							<div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget list-category">
									<h3 class="title">{{ __('web.category') }}</h3>
									<div class="list-group list-group-root">
										@php
											$categories = Helper::getAllCategory();
										@endphp
										@foreach($categories as $key1 => $lv1)
											@if($lv1->child_cat->count() > 0)
												<a href="#item-{{ $key1 }}" class="list-group-item list-group-item-action" data-toggle="collapse">
													<i class="fa fa-angle-right" aria-hidden="true"></i>{{$lv1->title}}
												</a>
												<div class="list-group collapse" id="item-{{ $key1 }}">
													@foreach($lv1->child_cat as $key2 => $lv2)
														@if($lv2->child_cat->count() > 0)
															<a href="#item-{{ $key1 }}-{{ $key2 }}" class="list-group-item list-group-item-action" data-toggle="collapse">
																<i class="fa fa-angle-right" aria-hidden="true"></i>{{$lv2->title}}
															</a>
															<div class="list-group collapse" id="item-{{ $key1 }}-{{ $key2 }}">
																@foreach($lv2->child_cat as $key3 => $lv3)
																	<a href="#" class="list-group-item list-group-item-action">&nbsp;{{$lv3->title}}</a>
																@endforeach
															</div>
														@else
														<a href="{{route('product-sub-cat',[$lv1->slug,$lv2->slug])}}" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;{{$lv2->title}}</a>
														@endif
													@endforeach
												</div>
											@else
												<a href="{{route('product-cat', $lv1->slug)}}" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;{{$lv1->title}}</a>
											@endif
										@endforeach
									</div>
								</div>
                                <!--/ End Single Widget -->
                                <!-- Shop By Price -->
								<div class="single-widget range">
									<h3 class="title">{{ __('web.filter_by_price') }}</h3>
									<div class="price-filter">
										<div class="price-filter-inner">
											{{-- <div id="slider-range" data-min="10" data-max="2000" data-currency="%"></div>
												<div class="price_slider_amount">
												<div class="label-input">
													<span>Range:</span>
													<input type="text" id="amount" name="price_range" value='@if(!empty($_GET['price'])) {{$_GET['price']}} @endif' placeholder="Add Your Price"/>
												</div>
											</div> --}}
											@php
												$max=DB::table('products')->max('price');
												// dd($max);
											@endphp
											<div id="slider-range" data-min="0" data-max="{{$max}}"></div>
											<div class="product_filter">
												<div class="label-input">
													<span>{{ __('web.product_price') }}:</span>
													<input style="" type="text" id="amount" readonly/>
													<input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"/>
												</div>
												<button type="submit" class="filter_button">{{ __('web.filter') }}</button>
											</div>
										</div>
									</div>
									{{-- <ul class="check-box-list">
										<li>
											<label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 - $50<span class="count">(3)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 - $100<span class="count">(5)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 - $250<span class="count">(8)</span></label>
										</li>
									</ul> --}}
								</div>
								<!--/ End Shop By Price -->
                                <!-- Single Widget -->
                                <div class="single-widget recent-post d-none">
                                    <h3 class="title">{{ __('web.recent_post') }}</h3>
                                    {{-- {{dd($recent_products)}} --}}
                                    @foreach($recent_products as $product)
                                        <!-- Single Post -->
                                        @php 
                                            $photo=explode(',',$product->photo);
                                        @endphp
                                        <div class="single-post first">
                                            <div class="image">
                                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            </div>
                                            <div class="content">
                                                <h5><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h5>
                                                @php
                                                    $org=($product->price-($product->price*$product->discount)/100);
                                                @endphp
                                                <p class="price"><del class="text-muted">{{number_format($product->price)}} VND</del> {{number_format($org)}} VND </p>                                                
                                            </div>
                                        </div>
                                        <!-- End Single Post -->
                                    @endforeach
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Single Widget -->
                                <div class="single-widget brands">
                                    <h3 class="title">{{ __('web.brand') }}</h3>
                                    <ul class="categor-list">
                                        @php
                                            $brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                                        @endphp
                                        @foreach($brands as $brand)
                                            <li><a href="{{route('product-brand',$brand->slug)}}">{{$brand->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                        	</div>
						</div>
						<div class="col-lg-9 col-md-8 col-12">
							<div class="row">
								<div class="col-12">
									<!-- Shop Top -->
									<div class="shop-top">
										<div class="shop-shorter">
											<div class="single-shorter">
												<label>{{ __('web.show') }} :</label>
												<select class="show" name="show" onchange="this.form.submit();">
													<option value="">{{ __('web.default') }}</option>
													<option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
													<option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
													<option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
													<option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
												</select>
											</div>
											<div class="single-shorter">
												<label>{{ __('web.sort_by') }} :</label>
												<select class='sortBy' name='sortBy' onchange="this.form.submit();">
													<option value="">{{ __('web.default') }}</option>
													<option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>{{ __('web.product_name') }}</option>
													<option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>{{ __('web.product_price') }}</option>
													<option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>{{ __('web.category') }}</option>
													<option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>{{ __('web.brand') }}</option>
												</select>
											</div>
										</div>
										<ul class="view-mode">
											<li><a href="{{route('product-grids')}}"><i class="ti-layout-grid2"></i></a></li>
											<li class="active"><a href="javascript:void(0)"><i class="ti-view-list-alt"></i></a></li>
										</ul>
									</div>
									<!--/ End Shop Top -->
								</div>
							</div>
							<div class="row">
								@if(count($products))
									@foreach($products as $product)
									 	{{-- {{$product}} --}}
										<!-- Start Single List -->
										<div class="col-12 product-item">
											<div class="row">
												<div class="col-lg-4 col-md-6 col-sm-6">
													<div class="single-product">
														<div class="product-img mt-4">
															<a href="{{route('product-detail',$product->slug)}}">
															@php 
																$photo=explode(',',$product->photo);
															@endphp
															<img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
															<img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
															</a>
															<div class="button-head">
																<div class="product-action">
																	<a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" class="wishlist" data-id="{{$product->id}}"><i class=" ti-heart "></i><span>{{ __('web.add_to_wishlist') }}</span></a>
																</div>
																<div class="product-action-2">
																	<a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">{{ __('web.add_to_cart') }}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-8 col-md-6 col-12">
													<div class="list-content">
														<div class="product-content">
													
															@php
																$after_discount=($product->price-($product->price*$product->discount)/100);
															@endphp
															<span class="product-price">{{number_format($after_discount)}} VND</span>
															<span class="product-price-old">{{number_format($product->price)}} VND</span>
															
															<h3 class="title"><a class="product-name" href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
														</div>
														<div class="des pt-2">{!! html_entity_decode($product->summary) !!}</div>
														<a href="javascript:void(0)" class="btn cart" data-id="{{$product->id}}">{{ __('web.add_to_cart') }}</a>
													</div>
												</div>
											</div>
										</div>
										<!-- End Single List -->
									@endforeach
								@else
									<p class="text-secondary" style="margin:100px auto;"><i class="ti-info-alt"></i> {{ __('web.no_product') }}</p>
								@endif
							</div>
							 <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{-- {{$products->appends($_GET)->links()}}  --}}
                            </div>
                          </div>
						</div>
					</div>
				</div>
			</section>
			<!--/ End Product Style 1  -->	
		</form>
@endsection
@push ('styles')
<style>
	 .pagination{
        display:inline-flex;
    }
	.filter_button{
        text-align: center;
        background:#ffc50c;
        padding:8px 16px;
        margin-top:10px;
        color: white;
        border: 0;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						}); 
                    }
                }
            })
        });
	</script> --}}
	<script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

@endpush