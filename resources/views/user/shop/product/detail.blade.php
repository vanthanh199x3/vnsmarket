@extends('user.layouts.master')
@section('title', $product->title)
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.view_detail') }}</h5>
    <div class="card-body">

        <div class="form-group">
          <label for="inputTitle" class="">{{ __('adm.product_name') }}:</label><b class="ml-2">{{$product->title}}</b>
        </div>

        <div class="form-group">
          <label for="summary" class="">{{ __('adm.summary') }} <span class="text-danger">*</span></label>
          <div class="border py-1 px-2 rounded">
            {!! $product->summary !!}
          </div>
        </div>

        <div class="form-group">
          <label for="description" class="">{{ __('adm.description') }}</label>
          <div class="border py-1 px-2 rounded">
            {!! $product->description !!}
          </div>
        </div>

        <div class="form-group">
          <label for="is_featured">{{ __('adm.is_featured_product') }} <b>{{ $product->is_featured ? __('adm.yes') : __('adm.no') }}</b></label>                     
        </div>

        <div class="form-group">
            <label for="cat_id">{{ __('adm.product_category') }}: <b>{{ $product->cat_info->title }}</b></label>
        </div>

        <div class="form-group">
            <label for="cat_id">{{ __('adm.brand') }}: <b>{{ $product->brand->title }}</b></label>
        </div>
      
        <div class="form-group row">
          <div class="col-md-4">
            <label class="">{{ __('adm.product_import_price') }}</label>
            <input type="number" name="import_price" placeholder="{{ __('adm.product_import_price') }}"  value="{{$product->import_price}}" class="form-control">
            @error('import_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="price" class="">{{ __('adm.product_price') }} <span class="text-danger">*</span></label>
            <input id="price" type="number" name="price" placeholder="{{ __('adm.product_price') }}"  value="{{$product->price}}" class="form-control">
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="discount" class="">{{ __('adm.product_discount') }}</label>
            <input id="discount" type="number" name="discount" min="0" max="100" placeholder="{{ __('adm.product_discount') }}"  value="{{$product->discount}}" class="form-control">
            @error('discount')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="border rounded p-4 my-4">
          <div class="form-group row">
            <div class="col-md-6">
              <label for="wallet_address" class="">{{ __('adm.product_price_token') }}</label>
              <input id="price_token" type="text" name="price_token" placeholder="{{ __('adm.product_price_token') }}"  value="{{$product->price_token}}" class="form-control">
              @error('price_token')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="col-md-6">
              <label>Đơn vị giá</label>
              <select name="price_token_unit" class="form-control">
                @if(!empty($tokenUnits))
                  @foreach($tokenUnits as $unit)
                    <option value="{{ $unit->id }}" {{ $unit->id == $product->price_token_unit ? 'slected' : '' }}>{{ $unit->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <label for="free_token" class="">{{ __('adm.free_token') }}</label>
              <input id="free_token" type="text" name="free_token" placeholder="{{ __('adm.free_token') }}"  value="{{$product->free_token}}" class="form-control">
              @error('free_token')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="wallet_address" class="">{{ __('adm.wallet_address') }}</label>
              <input id="wallet_address" type="text" name="wallet_address" value="{{$product->wallet_address}}" placeholder="{{ __('adm.wallet_address') }}"  value="{{$product->wallet_address}}" class="form-control">
              @error('wallet_address')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-3">
            <label for="unit">{{ __('adm.product_unit') }}</label>
            <select name="unit_id" class="form-control select2">
                <option value="">{{ __('adm.select') }}</option>
                @foreach($units as $unit)
                  <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="condition">{{ __('adm.product_condition') }}</label>
            <select name="condition" class="form-control">
                <option value="default" {{(($product->condition=='default')? 'selected':'')}}>Mặc định</option>
                <option value="new" {{(($product->condition=='new')? 'selected':'')}}>Mới</option>
                <option value="hot" {{(($product->condition=='hot')? 'selected':'')}}>Hot</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="stock">{{ __('adm.product_quantity') }} <span class="text-danger">*</span></label>
            <input id="quantity" type="number" name="stock" min="0" placeholder="{{ __('adm.product_quantity') }}"  value="{{$product->stock}}" class="form-control">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-3">
            <label for="status" class="">{{ __('adm.status') }} <span class="text-danger">*</span></label>
              <select name="status" class="form-control">
                <option value="active" {{(($product->status=='active')? 'selected' : '')}}>{{ __('adm.active') }}</option>
                <option value="inactive" {{(($product->status=='inactive')? 'selected' : '')}}>{{ __('adm.inactive') }}</option>
              </select>
              @error('status')
              <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
        </div>
       
        
        <div class="form-group mb-2 mt-4">
           <a class="btn btn-success" href="{{ url()->previous() }}">{{ __('adm.return') }}</a>
        </div>

    </div>
</div>

@endsection
