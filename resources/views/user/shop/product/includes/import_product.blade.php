@if($products->count())
    <div class="row product-list" data-total="{{ $products->total() }}">
        @foreach($products as $product)
            @php
                $productLocal = \App\Models\Product::find($product->id);
            @endphp
            <div class="col-md-2 px-1 d-flex product-item">
                <div class="card mb-3 w-100">
                    @php
                        $photo = explode(',',$product->photo);
                    @endphp
                    <img class="card-img-top" src="{{ $photo[0] }}" height="180" loading="lazy">
                    <div class="card-body py-2 px-2">
                        <p class="mb-2">{{ $product->title }}</p>
                        <small class="text-muted d-block">{{ $product->cat_info->title ?? '' }}</small>
                        <small class="text-muted d-block">{{ $product->brand->title ?? '' }}</small>
                    </div>
                    <div class="card-footer pt-0 px-2 border-top-0">
                        <small>{{ __('adm.product_quantity') }}: <b class="text-secondary">{{ number_format($product->stock) }}</b></small>
                        <br>
                        <small>{{ __('adm.product_price') }}: <b class="text-danger">{{ number_format($product->price) }}</b></small>
                        <br>
                        <small>{{ __('adm.bonus') }}: <b class="text-success">{{ number_format($product->bonus()) }}</b></small>
                        
                        @if($productLocal && $productLocal->is_import == 1)
                            <span class="badge badge-success mt-1">Đã nhập</span>
                        @else
                            <div class="form-check mt-2 cb-product-import">
                                <input class="form-check-input product-id" type="checkbox" value="{{ $product->id }}" id="defaultCheck{{ $product->id }}">
                                <label class="form-check-label" for="defaultCheck{{ $product->id }}">
                                    {{ __('adm.choose') }}
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
