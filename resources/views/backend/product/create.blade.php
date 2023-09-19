@extends('backend.layouts.master')
@section('title',__('adm.add').' '.__('adm.product'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.add').' '.__('adm.product') }}</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}" id="formProduct" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="">{{ __('adm.product_name') }} <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.product_name') }}"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="">{{ __('adm.summary') }} <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="">{{ __('adm.description') }}</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="is_featured">{{ __('adm.is_featured_product') }}</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> {{ __('adm.yes') }}                        
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="cat_id">{{ __('adm.product_category') }} <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control select2">
                <option value="">{{ __('adm.select') }}</option>
                @foreach($categories as $key => $lv1)
                    <option value='{{$lv1->id}}'>{{$lv1->title}}</option>
                    @if($lv1->child_cat->count() > 0)
                      @foreach($lv1->child_cat as $key2 => $lv2)
                      <option value='{{$lv2->id}}'>\____{{$lv2->title}}</option>
                        @if($lv2->child_cat->count() > 0)
                          @foreach($lv2->child_cat as $key3 => $lv3)
                          <option value='{{$lv3->id}}'>\________{{$lv3->title}}</option>
                          @endforeach
                        @endif
                      @endforeach
                    @endif
                @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label for="brand_id">{{ __('adm.brand') }}</label>
            <select name="brand_id" class="form-control" required>
                <option value="">{{ __('adm.select') }}</option>
              @foreach($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->title}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
      <div class="clear"></div>
      <!--THANH DEV  -->
      <div class="form-group row">
              <div class="controls">
                <div class="multi-field-wrapper">
                  <div class="multi-fields">
                    <div class="multi-field">
                     <label class="control-label"><i class="fa fa-product-hunt"></i> Size (Kích cỡ)</label>
                      <input type="text"  name="size_name[]">
                      <label class="control-label"> Giá Nhập</label>
                      <input type="text" name="size_price[]">
                      <label class="control-label"> Giá Bán </label>
                      <input type="text" name="size_price_sale[]">
                      <button type="button" class="remove-field btn btn-primary"> Xoá</button>
                    </div>
                  </div>
                <button type="button" class="add-field btn btn-primary"> <i class="fa fa-plus"></i> Thêm size theo giá</button>
                </div>
              </div>
            </div>
          </div><!--End none-->
      <!--THANH DEV  -->
   <div class="clear"></div>
   
        <div class="form-group">
          <label>{{ __('adm.link_titkok') }}</label>
          <input type="text" name="link_tiktok" placeholder="{{ __('adm.link_titkok') }}"  value="{{old('link_tiktok')}}" class="form-control">
          @error('link_tiktok')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>{{ __('adm.link_youtube') }}</label>
          <input type="text" name="link_youtube" placeholder="{{ __('adm.link_youtube') }}"  value="{{old('link_youtube')}}" class="form-control">
          @error('link_youtube')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>{{ __('adm.link_facebook') }}</label>
          <input type="text" name="link_facebook" placeholder="{{ __('adm.link_facebook') }}"  value="{{old('link_facebook')}}" class="form-control">
          @error('link_facebook')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">{{ __('adm.sub_category') }}</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">{{ __('adm.select') }}</option>
          </select>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label class="">% Thanh  toán VNSe <span class="text-danger"></span></label>
           <input type="number" name="percent_VNSe" placeholder="% Thanh  toán VNSe"  class="form-control">
     
          </div>

          <div class="col-md-6">
            <label for="price" class="">Hoàn điểm VNSe <span class="text-danger"></span></label>
            <input  type="number" name="points_VNSe" placeholder="Hoàn điểm VNSe"   class="form-control">
         
          </div>
   
         </div><!--End group-->

        <div class="form-group row">
          <div class="col-md-4">
            <label class="">{{ __('adm.product_import_price') }} <span class="text-danger"></span></label>
            <input type="number" name="import_price" placeholder="{{ __('adm.product_import_price') }}"  value="{{old('import_price')}}" class="form-control">
            @error('import_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="price" class="">{{ __('adm.product_price') }} <span class="text-danger"></span></label>
            <input id="price" type="number" name="price" placeholder="{{ __('adm.product_price') }}"  value="{{old('price')}}" class="form-control">
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="discount" class="">{{ __('adm.product_discount') }}</label>
            <input id="discount" type="number" name="discount" min="0" max="100" placeholder="{{ __('adm.product_discount') }}"  value="{{old('discount')??0}}" class="form-control">
            @error('discount')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        
        <div class="border rounded p-4 my-4">
          <div class="form-group row">
            <div class="col-md-6">
              <label for="price_token" class="">{{ __('adm.product_price_token') }}</label>
              <input id="price_token" type="number" name="price_token" placeholder="{{ __('adm.product_price_token') }}"  value="{{old('price_token')?? ''}}" class="form-control">
              @error('price_token')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="col-md-6">
              <label>Đơn vị giá</label>
              <select name="price_token_unit" class="form-control">
                @if(!empty($tokenUnits))
                  @foreach($tokenUnits as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <label for="free_token" class="">{{ __('adm.free_token') }}</label>
              <input id="free_token" type="number" name="free_token" placeholder="{{ __('adm.free_token') }}"  value="{{old('free_token')?? ''}}" class="form-control">
              @error('free_token')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="wallet_address" class="">{{ __('adm.wallet_address') }}</label>
              <input id="wallet_address" type="text" name="wallet_address" placeholder="{{ __('adm.wallet_address') }}"  value="{{old('wallet_address')?? ''}}" class="form-control">
              @error('wallet_address')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <!-- <div class="form-group">
          <label for="size">{{ __('adm.product_size') }}</label>
          <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">{{ __('adm.select') }}</option>
              <option value="S">Small (S)</option>
              <option value="M">Medium (M)</option>
              <option value="L">Large (L)</option>
              <option value="XL">Extra Large (XL)</option>
          </select>
        </div> -->

        <div class="form-group row">
          <div class="col-md-3">
            <label for="unit">{{ __('adm.product_unit') }}</label>
            <select name="unit_id" class="form-control select2">
                <option value="">{{ __('adm.select') }}</option>
                @foreach($units as $unit)
                  <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="condition">{{ __('adm.product_condition') }} <span class="text-danger">*</span></label>
            <select name="condition" class="form-control">
                <option value="default">Mặc định</option>
                <option value="new">Mới</option>
                <option value="hot">Hot</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="stock">{{ __('adm.product_quantity') }} <span class="text-danger">*</span></label>
            <input id="quantity" type="number" name="stock" min="0" placeholder="{{ __('adm.product_quantity') }}"  value="{{old('stock')}}" class="form-control">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-3">
            <label for="status">{{ __('adm.status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
                <option value="active">{{ __('adm.active') }}</option>
                <option value="inactive">{{ __('adm.inactive') }}</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="inputPhoto" class="">{{ __('adm.photo') }} <span class="text-danger">*</span> <span class="text-secondary">(Kích thước khuyến nghị: 500x500)</span></label>
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> {{ __('adm.choose') }}
                    </a>
                </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">{{ __('adm.reset') }}</button>
           <button class="btn btn-success" type="submit">{{ __('adm.save') }}</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "{{ __('adm.description') }}",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "{{ __('adm.description') }}",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

    $("#formProduct").validate({
      rules: {
        title: {
          required: true,
        },
        summary: {
          required: true,
        },
        cat_id: {
          required: true,
        },
        link_tiktok: {
          required: false,
          url: true
        },
        link_youtube: {
          required: false,
          url: true
        },
        link_facebook: {
          required: false,
          url: true
        },
        import_price: {
          required: false,
          number: true
        },
        price: {
          required: false,
          number: true
        },
        discount: {
          required: false,
          number: true
        },
        price_token: {
          required: false,
          number: true
        },
        free_token: {
          required: false,
          number: true
        },
        stock:{
          required: true
        },
        photo:{
          required: true
        }
      }
    });

</script>

<!-- <script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>{{ __('adm.select') }}</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script> -->
@endpush