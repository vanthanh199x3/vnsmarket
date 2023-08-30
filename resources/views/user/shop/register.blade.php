@extends('user.layouts.master')
@section('title', 'Bán hàng cùng VNSMARKET')
@section('main-content')
<div class="card mx-2">
    <h5 class="card-header">Bán hàng cùng VNSMARKET</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @include('user.layouts.notification')
            </div>
        </div>
        @if(empty($shop))
            <form id="formRegister" action="{{route('user.shop.register')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_name') }}</label>
                            <input type="text" name="shop_name" class="form-control" value="Shop {{ auth()->user()->name }}">
                            @error('shop_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_domain') }}</label>
                            <input type="text" name="shop_domain" class="form-control" value="" placeholder="Ví dụ: shopquatang (không cần nhập .vnsmarket.vn)">
                            @error('shop_domain')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_phone') }}</label>
                            <input type="text" name="shop_phone" class="form-control" value="{{ auth()->user()->phone }}">
                            @error('shop_phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_address') }}</label>
                            <input type="text" name="shop_address" class="form-control" value="">
                            @error('shop_address')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('adm.register') }}</button>
            </form>
        @endif

        @if(!empty($shop) && $shop->status == 0)
            <br>
            <span>Cửa hàng của bạn đang được kiểm duyệt. Chúng tôi sẽ thông tin đến bạn qua email của bạn ngay sau khi có kết quả kiểm duyệt.</span>
        @endif

  </div>
</div>
@endsection
@push('scripts')

<script>

    $.validator.addMethod("domain", function(value, element){
        return this.optional(element) || value == value.match(/^[a-z][a-z0-9]+$/);
    }, "Các ký tự cho phép a-z, 0-9, và phải bắt đầu bằng chữ");

    $("#formRegister").validate({
        rules: {
            shop_name: {
                required: true,
                minlength: 3,
                maxlength: 200,
            },
            shop_domain: {
                required: true,
                domain: true,
                minlength: 3,
                maxlength: 200,
            },
            shop_phone: {
                required: true,
                number: true
            },
            // shop_address: {
            //     required: true,
            // },
        }
    });
</script>
@endpush
