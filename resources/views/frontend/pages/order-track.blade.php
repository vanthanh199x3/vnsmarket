@extends('frontend.layouts.master')
@section('title', config('app.name').' - '. __('web.track_order'))
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">{{ __('web.track_order') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        @if(session('message'))
            <div class="message-success fade show mb-4">
                {!! session('message') !!}
            </div>
        @endif
        <div class="tracking_box_inner">
            <p>{{ __('web.track_order_title') }}</p>
            <form id="formTracking" class="row tracking_form my-4" action="{{route('product.track.order')}}" method="post" novalidate="novalidate">
                @csrf
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="{{ __('web.order_number') }}">
                </div>
                <div class="col-md-2 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">{{ __('web.check_order') }}</button>
                </div>
            </form>
        </div>
        <!-- <div class="histories">
            @if(!empty($orders))
                <p>Mua gần đây:</p>
                <ul class="mt-3">
                @foreach($orders as $order)
                    <li class="history-item mb-3" data-id="{{ $order->order_number }}">
                    Thời gian: {{ $order->created_at->format('d/m/Y H:i') }} - ID: <b>{{ $order->order_number }}</b>
                    </li>
                @endforeach
                </ul>
            @endif
        </div> -->
    </div>
</section>
@endsection

@push('scripts')
<script>
    $("#formTracking").validate({
        rules: {
            order_number: {
                required: true,
            }
        }
    });

    // $('.histories .history-item').click(function() {
    //     let orderNumber = $(this).attr('data-id');
    //     $('.tracking_box_inner input[name="order_number"]').val(orderNumber);
    //     $('.tracking_box_inner button[type="submit"]').click();
    // })
</script>
@endpush