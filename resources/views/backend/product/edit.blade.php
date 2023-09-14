@extends('backend.layouts.master')
@section('title',__('adm.edit').' '.__('adm.product'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.edit').' '.__('adm.product') }}</h5>
    <div class="card-body">
 <input id="get_id_product" type="hidden" name="product_id" value="<?=$product->id;?>" />

      <form method="post" action="{{route('product.update',$product->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="">{{ __('adm.product_name') }} <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="{{ __('adm.product_name') }}"  value="{{$product->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="">{{ __('adm.summary') }} <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{$product->summary}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="">{{ __('adm.description') }}</label>
          <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="is_featured">{{ __('adm.is_featured_product') }}</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='{{$product->is_featured}}' {{(($product->is_featured) ? 'checked' : '')}}> {{ __('adm.yes') }}                         
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="cat_id">{{ __('adm.product_category') }} <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control select2">
                <option value="">{{ __('adm.select') }}</option>
                @foreach($categories as $key => $lv1)
                    <option value='{{$lv1->id}}' {{ $lv1->id == $product->cat_id ? 'selected' : '' }}>{{$lv1->title}}</option>
                    @if($lv1->child_cat->count() > 0)
                      @foreach($lv1->child_cat as $key2 => $lv2)
                      <option value='{{$lv2->id}}' {{ $lv2->id == $product->cat_id ? 'selected' : '' }}>\____{{$lv2->title}}</option>
                        @if($lv2->child_cat->count() > 0)
                          @foreach($lv2->child_cat as $key3 => $lv3)
                          <option value='{{$lv3->id}}' {{ $lv3->id == $product->cat_id ? 'selected' : '' }}>\________{{$lv3->title}}</option>
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
                <option value="{{$brand->id}}" {{(($product->brand_id==$brand->id)? 'selected':'')}}>{{$brand->title}}</option>
              @endforeach
            </select>
          </div>
        </div>

<!--THANH DEV  -->
<div class="clear"></div>
 <div class="form-group row">
  <div class="controls">
      <div class="multi-field-wrapper">
          <div class="multi-fields">
          <div class="multi-field_edit">
            <?php  $k=0;
               foreach ($edit_data_size as $d_size) { $k++;
            if(isset($d_size->product_id)){?>
            <label class="control-label"> Tên Size</label>
            <input type="text" name="size_name[]" value="<?=$d_size->size_name;?>">
            <label class="control-label"> Giá Nhập</label>
            <input type="text"  name="size_price[]" value="<?=$d_size->size_price;?>">
            <label class="control-label"> Giá Bán </label>
            <input type="text" name="size_price_sale[]" value="<?=$d_size->size_price_sale;?>">
            <input type="hidden" name="id_size[]" value="<?=$d_size->id;?>">
            <button type="button"  onclick="javascript:delete_size(<?=$d_size->id;?>)" class="remove-field btn btn-primary delete-size"><i class="fa fa-trash-o"></i> Xoá</button>
   <div class="clear"></div>

    <?php } else {'';}?>
   <?php }?>
 </div><!--End multi-field-->
 </div>
    <button type="button" class="add-field_edit btn btn-primary"> <i class="fa fa-plus"></i>Thêm Size theo giá</button> 
    </div>
 </div>
 </div> 
 <div class="clear"></div> 
 
 <!--THANH DEV  -->


        <div class="form-group">
          <label>{{ __('adm.link_titkok') }}</label>
          <input type="text" name="link_tiktok" placeholder="{{ __('adm.link_titkok') }}"  value="{{ $product->link_tiktok }}" class="form-control">
          @error('link_tiktok')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>{{ __('adm.link_youtube') }}</label>
          <input type="text" name="link_youtube" placeholder="{{ __('adm.link_youtube') }}"  value="{{ $product->link_youtube }}" class="form-control">
          @error('link_youtube')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>{{ __('adm.link_facebook') }}</label>
          <input type="text" name="link_facebook" placeholder="{{ __('adm.link_facebook') }}"  value="{{ $product->link_facebook }}" class="form-control">
          @error('link_facebook')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
      
        <div class="form-group row">
          <div class="col-md-4">
            <label class="">{{ __('adm.product_import_price') }} <span class="text-danger"></span></label>
            <input type="number" name="import_price" placeholder="{{ __('adm.product_import_price') }}"  value="{{$product->import_price}}" class="form-control">
            @error('import_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="price" class="">{{ __('adm.product_price') }} <span class="text-danger"></span></label>
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

        <!-- <div class="form-group">
          <label for="size">{{ __('adm.product_size') }}</label>
          <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">{{ __('adm.select') }}</option>
              @foreach($items as $item)              
                @php 
                $data=explode(',',$item->size);
                // dd($data);
                @endphp
              <option value="S"  @if( in_array( "S",$data ) ) selected @endif>Small</option>
              <option value="M"  @if( in_array( "M",$data ) ) selected @endif>Medium</option>
              <option value="L"  @if( in_array( "L",$data ) ) selected @endif>Large</option>
              <option value="XL"  @if( in_array( "XL",$data ) ) selected @endif>Extra Large</option>
              @endforeach
          </select>
        </div> -->

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
            <label for="condition">{{ __('adm.product_condition') }} <span class="text-danger">*</span></label>
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

        <div class="form-group row">
          <div class="col-md-6">
            <label for="inputPhoto" class="">{{ __('adm.photo') }} <span class="text-danger">*</span> <span class="text-secondary">(Kích thước khuyến nghị: 500x500)</span></label>
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fas fa-image"></i> {{ __('adm.choose') }}
                    </a>
                </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$product->photo}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">{{ __('adm.update') }}</button>
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
        height: 150
    });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "{{ __('adm.description') }}",
          tabsize: 2,
          height: 150
      });
    });
</script>

<script>
  // var  child_cat_id='{{$product->child_cat_id}}';
  // // alert(child_cat_id);
  // $('#cat_id').change(function(){
  //     var cat_id=$(this).val();

  //     if(cat_id !=null){
  //         // ajax call
  //         $.ajax({
  //             url:"/admin/category/"+cat_id+"/child",
  //             type:"POST",
  //             data:{
  //                 _token:"{{csrf_token()}}"
  //             },
  //             success:function(response){
  //                 if(typeof(response)!='object'){
  //                     response=$.parseJSON(response);
  //                 }
  //                 var html_option="<option value=''>{{ __('adm.select') }}</option>";
  //                 if(response.status){
  //                     var data=response.data;
  //                     if(response.data){
  //                         $('#child_cat_div').removeClass('d-none');
  //                         $.each(data,function(id,title){
  //                             html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
  //                         });
  //                     }
  //                     else{
  //                         console.log('no response data');
  //                     }
  //                 }
  //                 else{
  //                     $('#child_cat_div').addClass('d-none');
  //                 }
  //                 $('#child_cat_id').html(html_option);

  //             }
  //         });
  //     }
  //     else{

  //     }

  // });
  // if(child_cat_id!=null){
  //     $('#cat_id').change();
  // }
  $("#formProduct").validate({
      rules: {
        title: {
          required: true,
        },
        summary: {
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
        cat_id: {
          required: true,
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

<script type="text/javascript">
  function delete_size(id)
  {
    var answer = confirm ("Bạn có chắc là muốn xóa ");
    var product_id=$("#get_id_product").val();
    if (answer)
    {
      $.ajax({
        type: "POST",
        url: "<?=url('ajax_delete_muti_size');?>",
        data: {
                id: id,product_id:product_id
         },
        success: function (data) {
            location.reload();
        }

      });
    }

  }

    var newIn ='';
    $(".add-field_edit").click(function(e) {
        newIn ='<div class="clear"></div>';
        newIn +='<div class="wap_add">';
        newIn +='<label class="control-label"> Tên Size </label>';
        newIn +=' <input type="text"  name="size_name[]"> ';
        newIn +='<label class="control-label"> Giá Nhập </label>';
        newIn +=' <input type="text"  name="size_price[]">';
        newIn +='<label class="control-label"> <i class="fa fa-usd"></i> Giá Bán </label>';
        newIn +='<input type="text"   name="size_price_sale[]"> ';
        newIn +=' <button type="button" class="remove-field btn btn-primary"><i class="fa fa-trash-o"></i> Xoá</button>';
        newIn +='<div class="clear"></div>';
        $('.multi-field_edit:last-child').append(newIn);
         $('.remove-field').click(function() {
            $('.wap_add').remove();
       });
});
</script>
@endpush