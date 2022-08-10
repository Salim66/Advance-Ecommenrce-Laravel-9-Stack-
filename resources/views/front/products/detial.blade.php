@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li><a href="{{ url('/'.$product_detail->category->url ) }}">{{ $product_detail->category->category_name }}</a> <span class="divider">/</span></li>
        <li class="active">{{ $product_detail->product_name }}</li>
    </ul>
    <div class="row">
        <div id="gallery" class="span3">
            <a href="{{ URL::to('images/product_images/large/'.$product_detail->main_image) }}" title="Blue Casual T-Shirt">
                <img src="{{ URL::to('images/product_images/medium/'.$product_detail->main_image) }}" style="width:100%" alt="Blue Casual T-Shirt"/>
            </a>
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                    <div class="item active">
                        @foreach($product_detail->images as $image)
                        <a href="{{ URL::to('images/product_images/large/'.$image->image) }}"> <img style="width:29%" src="{{ URL::to('images/product_images/small/'.$image->image) }}" alt=""/></a>
                        @endforeach
                    </div>
                </div>
                <!--
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                -->
            </div>

            <div class="btn-toolbar">
                <div class="btn-group">
                    <span class="btn"><i class="icon-envelope"></i></span>
                    <span class="btn" ><i class="icon-print"></i></span>
                    <span class="btn" ><i class="icon-zoom-in"></i></span>
                    <span class="btn" ><i class="icon-star"></i></span>
                    <span class="btn" ><i class=" icon-thumbs-up"></i></span>
                    <span class="btn" ><i class="icon-thumbs-down"></i></span>
                </div>
            </div>
        </div>
        <div class="span6">
            @if(session()->has('success_message'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session()->has('error_message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <h3>{{ $product_detail->product_name }}  </h3>
            <small>- {{ $product_detail->brand->name }}</small>
            <hr class="soft"/>

            @if(count($groupProducts) > 0)
                <div>
                    <div><strong>More Colors</strong></div>
                    <div>
                        @foreach ($groupProducts as $product)
                            <a href="{{ url('/product/'.$product->id) }}"><img style="width: 50px; margin-bottom: 10px;" src="{{ URL::to('images/product_images/small/'.$product->main_image) }}" alt=""></a>
                        @endforeach
                    </div>
                </div>
            @endif

            <small>{{ $total_stock }} items in stock</small>
            <form action="{{ url('/add-to-cart') }}" method="POST" class="form-horizontal qtyFrm">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product_detail->id }}">
                @php
                    $discount_price = \App\Models\Product::getDiscountPrice($product_detail->id);
                @endphp
                <div class="control-group">
                    <h4 class="setProductPrice">
                        @if($discount_price>0)
                            <del>Rs. {{ $product_detail->product_price }}</del> Rs. {{ $discount_price }}
                        @else
                            Rs. {{ $product_detail->product_price }}
                        @endif

                    </h4>
                        <select name="size" class="getProductPrice" product_id="{{ $product_detail->id }}" class="span2 pull-left" required>
                            <option value="" disabled selected>Select Size</option>
                            @foreach($product_detail->attributes as $att)
                            <option value="{{ $att->size }}">{{ $att->size }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="quantity" class="span1" placeholder="Qty." required />
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i class=" icon-shopping-cart"></i></button><br><br>
                        <strong>Delivery</strong>
                        <input type="text" style="width: 120px;" name="pincode" id="pincode" placeholder="Pin">
                        <button type="button" id="checkPincode">Check Pin</button>
                    </div>
                </div>
            </form>

            <hr class="soft clr"/>
            <p class="span6">
                {{ $product_detail->description }}
            </p>
            <a class="btn btn-small pull-right" href="#detail">More Details</a>
            <br class="clr"/>
            <a href="#" name="detail"></a>
            <hr class="soft"/>
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                <li><a href="#profile" data-toggle="tab">Related Products</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Brand: </td><td class="techSpecTD2">{{ $product_detail->brand->name }}</td></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Code:</td><td class="techSpecTD2">{{ $product_detail->product_code }}</td></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Color:</td><td class="techSpecTD2">{{ $product_detail->product_color }}</td></tr>
                            @if($product_detail->fabric)
                            <tr class="techSpecRow"><td class="techSpecTD1">Fabric:</td><td class="techSpecTD2">{{ $product_detail->fabric }}</td></tr>
                            @endif
                            @if($product_detail->pattern)
                            <tr class="techSpecRow"><td class="techSpecTD1">Pattern:</td><td class="techSpecTD2">{{ $product_detail->pattern }}</td></tr>
                            @endif
                            @if($product_detail->sleeve)
                            <tr class="techSpecRow"><td class="techSpecTD1">Sleeve:</td><td class="techSpecTD2">{{ $product_detail->sleeve }}</td></tr>
                            @endif
                            @if($product_detail->fit)
                            <tr class="techSpecRow"><td class="techSpecTD1">Fit:</td><td class="techSpecTD2">{{ $product_detail->fit }}</td></tr>
                            @endif
                            @if($product_detail->occasion)
                            <tr class="techSpecRow"><td class="techSpecTD1">Occasion:</td><td class="techSpecTD2">{{ $product_detail->occasion }}</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <h5>Washcare</h5>
                    <p>{{ $product_detail->wash_care }}</p>
                    <h5>Disclaimer</h5>
                    <p>
                        There may be a slight color variation between the image shown and original product.
                    </p>
                </div>
                <div class="tab-pane fade" id="profile">
                    <div id="myTab" class="pull-right">
                        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
                        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
                    </div>
                    <br class="clr"/>
                    <hr class="soft"/>
                    <div class="tab-content">
                        <div class="tab-pane" id="listView">
                            @foreach($related_product as $relative)
                            <div class="row">
                                <div class="span2">
                                    @if(!empty($relative->main_image) && file_exists('images/product_images/small/'.$relative->main_image))
                                    <img src="{{ URL::to('images/product_images/small/'.$relative->main_image) }}" alt=""/>
                                    @else
                                    <img src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt=""/>
                                    @endif
                                </div>
                                <div class="span4">
                                    <h3>New | Available</h3>
                                    <hr class="soft"/>
                                    <h5>{{ $relative->product_name }} </h5>
                                    <p>
                                        {{ $relative->description }}
                                    </p>
                                    <a class="btn btn-small pull-right" href="{{ url('product/'.$relative->id) }}">View Details</a>
                                    <br class="clr"/>
                                </div>
                                <div class="span3 alignR">
                                    <form class="form-horizontal qtyFrm">
                                        <h3> Rs. {{ $relative->product_price }}</h3>
                                        <label class="checkbox">
                                            <input type="checkbox">  Adds product to compair
                                        </label><br/>
                                        <div class="btn-group">
                                            <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                                            <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr class="soft"/>
                            @endforeach
                        </div>
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach($related_product as $relative)
                                <li class="span3">
                                    <div class="thumbnail">
                                        @if(!empty($relative->main_image) && file_exists('images/product_images/small/'.$relative->main_image))
                                        <a href="{{ url('product/'.$relative->id) }}"><img src="{{ URL::to('images/product_images/small/'.$relative->main_image) }}" alt=""/></a>
                                        @else
                                        <a href="{{ url('product/'.$relative->id) }}"><img src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt=""/></a>
                                        @endif
                                        <div class="caption">
                                            <h5>{{ $relative->product_name }}</h5>
                                            <p>
                                                {{ $relative->description }}
                                            </p>
                                            <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs. {{  $relative->product_price  }}</a></h4>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <hr class="soft"/>
                        </div>
                    </div>
                    <br class="clr">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
