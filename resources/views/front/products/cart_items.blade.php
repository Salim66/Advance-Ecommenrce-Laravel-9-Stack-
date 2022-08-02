<table class="table table-bordered">
    <thead>
        <tr>
        <th>Product</th>
        <th colspan="2">Description</th>
        <th>Quantity/Update</th>
        <th>Price</th>
        <th>Product/Categrey <br>Discount</th>
        <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_price = 0;
        @endphp
        @foreach($user_cart_items as $item)
            @php
                $get_attr_price = \App\Models\Product::getDiscountedAttrPrice($item->product->id, $item->size);
            @endphp
        <tr>
            <td> <img width="60" src="{{ URL::to('images/product_images/small/'.$item->product->main_image) }}" alt=""/></td>
            <td>{{ $item->product->product_name }} ({{ $item->product->product_code }})<br/>Color : {{ $item->product->product_color }}</td>
            <td colspan="2">
                <div class="input-append">
                    <input class="span1" style="max-width:34px" value="{{ $item->quantity }}" id="appendedInputButtons" size="16" type="text">
                    <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item->id }}"><i class="icon-minus"></i></button>
                    <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $item->id }}"><i class="icon-plus"></i></button>
                    <button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $item->id }}"><i class="icon-remove icon-white"></i></button>
                </div>
            </td>
            <td>Rs.{{ $get_attr_price['product_price'] }}</td>
            <td>Rs.{{ $get_attr_price['discount'] }}</td>
            <td>Rs.{{ $item->quantity * $get_attr_price['final_price'] }}</td>
        </tr>
        @php
            $total_price = $total_price + ( $item->quantity * $get_attr_price['final_price'] );
        @endphp
        @endforeach

        <tr>
        <td colspan="6" style="text-align:right">Total Price:	</td>
        <td> Rs.{{ $total_price }}</td>
        </tr>
        <tr>
        <td colspan="6" style="text-align:right">Coupon Discount:	</td>
        <td class="coupon_amount">
            @if(Session::get('coupon_amount'))
             Rs. {{ Session::get('coupon_amount') }}
            @else
             Rs. 0.00
            @endif
        </td>
        </tr>
        <tr>
        <td colspan="6" style="text-align:right"><strong>TOTAL (Rs.{{ $total_price }} - <span class="coupon_amount">Rs.0</span>) =</strong></td>
        <td class="label label-important" style="display:block"> <strong class="grand_total"> Rs. {{ $total_price - Session::get('coupon_amount') }} </strong></td>
        </tr>
    </tbody>
</table>
