
@if ($get_size_row->size_price_sale > 0)
    <span class="product-price">{{ number_format($get_size_row->size_price_sale) }}₫</span>
@endif

<span class="old-price">
    @if ($get_size_row->size_price == 0 && $get_size_row->size_price_sale == 0)
        <span class="call_me">Liên hệ</span>
    @elseif ($get_size_row->size_price_sale == 0)
        <span class="product-price">{{ number_format($get_size_row->size_price) }} ₫</span>
    @else
        <del class="price-number">{{ number_format($get_size_row->size_price) }}₫</del>
    @endif

    @if ($get_size_row->size_price != 0 && $get_size_row->size_price_sale != 0)
        <span class="text-primary percent">
            <?php
            $percent = ($get_size_row->size_price - $get_size_row->size_price_sale) / $get_size_row->size_price * 100;
            $rs_percent = number_format($percent);
            echo '-' . round($rs_percent) . '%';
            ?>
        </span>
    @endif
</span>

          <style type="text/css">
            .product-price
            {
              font-size: 20px;
              margin-right: 15px;
              color: #444;
              font-weight: 600;
              line-height: 30px;
            }
            .percent
            {
              float: right;
            }
            .old-price
            {
              display: none;
            }
          </style>