@extends('backend.layouts.master')
@section('title', __('adm.add') . ' ' . __('adm.brand'))
@section('main-content')

    <div class="card mx-2">
        <h5 class="card-header">{{ __('adm.add') . ' ' . __('adm.brand') }}</h5>
        <div class="card-body">
            <form method="post" action="{{ route('brand.store') }}" id="formBrand">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-6">
                        <label for="inputTitle" class="col-form-label">{{ __('adm.name') }} <span
                                class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.name') }}"
                            value="{{ old('title') }}" class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="inputTitle" class="col-form-label">{{ __('adm.phone') }} <span
                                class="text-danger">*</span></label>
                        <input id="inputPhone" type="text" name="phone" placeholder="{{ __('adm.phone') }}"
                            value="{{ old('phone') }}" class="form-control">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="status" class="col-form-label">{{ __('adm.status') }} <span
                                class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="active">{{ __('adm.active') }}</option>
                            <option value="inactive">{{ __('adm.inactive') }}</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>{{ __('web.province') }}<span>*</span></label>
                            <select name="province" id="province-select" class="select2"
                                style="width:100%" required>
                                <option value="">{{ __('web.select_province') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>{{ __('web.district') }}<span>*</span></label>
                            <select name="district" id="district-select" class="select2"
                                style="width:100%" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>{{ __('web.ward') }}<span>*</span></label>
                            <select name="ward" id="ward-select" class="select2" style="width:100%" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>{{ __('web.address_1') }}<span>*</span></label>
                            <input type="text" name="address" placeholder=""
                                value="{{ auth()->user()->address }}" class="form-control" required>
                            @error('address1')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning mt-4">{{ __('adm.reset') }}</button>
                    <button class="btn btn-success mt-4" type="submit">{{ __('adm.save') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function() {
            // Lấy danh sách tỉnh thành từ API và điền vào select box
            $.ajax({
                url: '/api/address/provinces',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#province-select');

                    $.each(data, function(key, value) {
                        select.append('<option value="' + value.name + '" data-code="' + value.code + '">' + value.name +
                            '</option>');
                    });
                }
            });

            // Gọi AJAX khi thay đổi giá trị của select tỉnh thành
            $('#province-select').on('change', function() {
                var provinceCode = $(this).find('option:selected').data('code');

                $.ajax({
                    url: '/api/address/districts/' + provinceCode,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#district-select');
                        var htmlText = "";
                        $.each(data, function(key, value) {
                            htmlText +='<option value="' + value.name + '" data-code="' + value.code + '">' + value
                                .name + '</option>';
                        });
                        select.html(htmlText);
                        $('#ward-select').html("");
                    }
                });
            });

            // Gọi AJAX khi thay đổi giá trị của select quận huyện
            $('#district-select').on('change', function() {
                var districtCode = $(this).find('option:selected').data('code');

                $.ajax({
                    url: '/api/address/wards/' + districtCode,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#ward-select');
                        var htmlText = "";
                        $.each(data, function(key, value) {
                            htmlText +='<option value="' + value.name + '">' + value
                                .name + '</option>';
                        });
                        select.html(htmlText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#lfm').filemanager('image');

            $("#formBrand").validate({
                rules: {
                    title: {
                        required: true,
                    }
                },
            });

        });
    </script>
@endpush
