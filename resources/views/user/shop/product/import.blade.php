@extends('user.layouts.master')
@section('title',__('adm.import').' '.__('adm.product'))
@section('main-content')

<div class="card mx-2">
    <h5 class="card-header">{{ __('adm.import').' '.__('adm.product') }}</h5>
    <div class="card-body">
      {{-- {{csrf_field()}} --}}
      <div class="row filter">
        <div class="col-md-4">
          <input type="text" name="keyword" class="form-control" placeholder="{{ __('adm.product_name') }} ...">
        </div>
        <div class="col-md-3">
          <select name="cat_id" id="cat_id" class="form-control select2">
            <option value="">{{ __('adm.category') }}</option>
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
        <div class="col-md-3">
          <select name="brand_id" id="brand_id" class="form-control">
            <option value="">{{ __('adm.brand') }}</option>
            @foreach($brands as $brand)
              <option value="{{$brand->id}}">{{$brand->title}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success" id="filterProduct">{{ __('adm.search_for') }}</button>
          <button class="btn btn-warning" id="filterReset">{{ __('adm.reset') }}</button>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
          <p class="mt-3"><span class="total_result_found text-primary">(0)</span> {{__('adm.product')}}</p>
        </div>
        <div class="col-2">
          <p class="mt-3"><span class="total_selected text-success">(0)</span> Đã chọn</p>
        </div>
      </div>
      <div class="product-layout border py-2 px-3 rounded"></div>
      <button class="btn btn-primary mt-3 mr-2 loadMoreProduct d-none" data-page="1">{{ __('adm.load_more') }}</button>
      <button class="btn btn-success mt-3" id="importProduct"><i class="fas fa-arrow-down"></i>{{ __('adm.import') }}</button>
    </div>
</div>

@endsection

@push('styles')

@endpush
@push('scripts')
<script>

  $('#cat_id').select2();
  $('#brand_id').select2();

  getImportProduct(1);

  $('#filterProduct').click(function() {
    getImportProduct(1)
  });

  $('#filterReset').click(function() {
    $('.filter input[name="keyword"]').val('');
    $('.filter select[name="cat_id"]').val('').trigger('change');
    $('.filter select[name="brand_id"]').val('').trigger('change');
    getImportProduct(1)
  });

  $('.loadMoreProduct').click(function() {
    var page = $(this).attr('data-page');
    getImportProduct(page);
  });

  $(document).on('click', '.cb-product-import input', function() {
    var checked = $(".cb-product-import input:checked").length;
    $('.total_selected').text('(' + (checked ?? 0) + ')');
  });

  function getImportProduct(page) {
    var url = '{{ route('shop.product.import') }}'+'?page='+page;
    var keyword = $('.filter input[name="keyword"]').val();
    var cat_id = $('.filter select[name="cat_id"]').val();
    var brand_id = $('.filter select[name="brand_id"]').val();
    $.ajax({
      url: url,
      data:{
        keyword: keyword,
        cat_id: cat_id,
        brand_id: brand_id
      },
      method:"GET",
      success:function(res){
        if(res.html == ""){
          $('.loadMoreProduct').addClass("d-none");
        } else {
          if(page == 1) {
            $('.product-layout').empty();
          }
          $('.product-layout').append(res.html);
          $('.loadMoreProduct').removeClass("d-none");
          $('.loadMoreProduct').attr("data-page", parseInt(page) + 1);
          $('.total_result_found').text('(' +  ($('.product-list').attr('data-total') ?? 0) + ')')
        }
      }
    });
  }

  $('#importProduct').click(function() {
    var ids = [];
    $(".product-item .product-id").each(function( index ) {
      if ($(this).is(":checked")) {
        ids.push($(this).val());
      }
    });

    if ($.isEmptyObject(ids)) {
      swal("", 'Chưa chọn sản phẩm nhập!', 'error');
    } else {
      $.ajax({
        url: "{{ route('shop.product.importSubmit') }}",
        data:{
          ids: ids,
        },
        method:"POST",
        dataType: 'json',
        success:function(res){
          swal("", res.message, res.success ? "success" : 'error');
          if (res.success) {
            setTimeout(function(){ 
              window.location.href = '{{ route("shop.product.index") }}';
            }, 2000);
          }
        }
      });
    }
  });

</script>
@endpush