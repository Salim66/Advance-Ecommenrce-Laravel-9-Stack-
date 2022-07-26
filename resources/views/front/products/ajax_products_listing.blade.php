<div class="tab-pane" id="listView">
    @foreach($catProducts as $product)
    <div class="row">
        <div class="span2">
            @if(!empty($product['main_image']))
            <img src="{{ URL::to('images/product_images/small/'.$product['main_image']) }}" alt=""/>
            @else
            <img src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt=""/>
            @endif
        </div>
        <div class="span4">
            <h3>{{ $product['brand']['name'] }}</h3>
            <hr class="soft"/>
            <h5>{{ $product['product_name'] }} </h5>
            <p>
                {{ $product['description'] }}
            </p>
            <a class="btn btn-small pull-right" href="product_details.html">View Details</a>
            <br class="clr"/>
        </div>
        <div class="span3 alignR">
            <form class="form-horizontal qtyFrm">
                <h3> ${{ $product['product_price'] }}</h3>
                <label class="checkbox">
                    <input type="checkbox">  Adds product to compare
                </label><br/>

                <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>

            </form>
        </div>
    </div>
    <hr class="soft"/>
    @endforeach
</div>
<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach($catProducts as $product)
        @php
            $discount_price = \App\Models\Product::getDiscountPrice($product->id);
        @endphp
        <li class="span3">
            <div class="thumbnail">
                <a href="{{ url('product/'.$product->id) }}">
                    @if(!empty($product['main_image']))
                    <img src="{{ URL::to('images/product_images/small/'.$product['main_image']) }}" alt=""/>
                    @else
                    <img src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt=""/>
                    @endif
                </a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <p>
                        {{ $product['brand']['name'] }}
                    </p>
                    <h4 style="text-align:center"> <a class="btn" href="{{ url('product/'.$product->id) }}">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">
                       @if($discount_price>0)
                        <del>Rs.{{ $product['product_price'] }}</del>
                        <font color="yellow">Rs.{{ $discount_price }}</font>
                       @else
                        Rs.{{ $product['product_price'] }}
                       @endif
                    </a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>
