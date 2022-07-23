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
        <li class="span3">
            <div class="thumbnail">
                <a href="product_details.html">
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
                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product['product_price'] }}</a></h4>
                    <p>
                        {{ $product['fabric'] }}
                    </p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>
