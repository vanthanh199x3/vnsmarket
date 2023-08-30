@extends('backend.layouts.master')
@section('title', __('adm.shop') . ' ' . $shopInfo->shop_name)
@section('main-content')
<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.shop') . ' ' . $shopInfo->shop_name }}</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        @if(!empty($shopInfo))
            <form id="formRegister" action="{{route('shop.approved', $shopInfo->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_name') }}:</label>
                            <input type="text" name="shop_name" class="form-control" value="{{ $shopInfo->shop_name }}" readonly>
                            @error('shop_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_domain') }}</label>
                            <input type="text" name="shop_domain" class="form-control" value="{{ $shopInfo->shop_domain }}" readonly>
                            @error('shop_domain')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_phone') }}</label>
                            <input type="text" name="shop_phone" class="form-control" value="{{ $shopInfo->shop_phone }}" readonly>
                            @error('shop_phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('adm.shop_address') }}</label>
                            <input type="text" name="shop_address" class="form-control" value="{{ $shopInfo->shop_address }}" readonly>
                            @error('shop_address')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">{{ __('adm.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="0" {{ (($shopInfo->status == '0') ? 'selected' : '')}}>{{ __('adm.not_approved') }}</option>
                                <option value="1" {{ (($shopInfo->status == '1') ? 'selected' : '')}}>{{ __('adm.approved') }}</option>
                                <option value="2" {{ (($shopInfo->status == '2') ? 'selected' : '')}}>{{ __('adm.deny') }}</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">Thông tin cấu hình</label>
                            @if($shopInfo->env != '')
                                <div class="border rounded p-2">
                                    @php
                                        $env = json_decode($shopInfo->env);
                                        $i = 0;
                                        foreach($env as $key => $item) {
                                            if ($key == 'APP_NAME') $item = '"'.$item.'"';
                                            echo $key.'='.$item.'<br>';
                                        }
                                    @endphp
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ __('adm.update') }}</button>
            </form>
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