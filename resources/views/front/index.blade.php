@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{ $featuredItemsCount }} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" @if($featuredItemsCount > 4) class="carousel slide" @endif>
                <div class="carousel-inner">
                    @foreach($featuredItemsChunk as $key => $featuredItem)
                    <div class="item @if($key == 0) active @endif">
                        <ul class="thumbnails">
                            @foreach($featuredItem as $item)
                                @php
                                    $discount_price = \App\Models\Product::getDiscountPrice($item['id']);
                                @endphp
                            <li class="span3">
                                <div class="thumbnail">
                                    <i class="tag"></i>
                                    <a href="{{ url('product/'.$item['id']) }}">
                                        @if(!empty($item['main_image']) && file_exists('images/product_images/small/'.$item['main_image']))
                                        <img src="{{ URL::to('images/product_images/small/'.$item['main_image']) }}" alt="">
                                        @else
                                        <img src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt="">
                                        @endif
                                    </a>
                                    <div class="caption">
                                        <h5>{{ $item['product_name'] }}</h5>
                                        <h4><a class="btn" href="{{ url('product/'.$item['id']) }}">VIEW</a> <span class="pull-right" style="font-size: 13px;">
                                            @if($discount_price > 0)
                                                <del>Rs.{{ $item['product_price'] }}</del>
                                                <font color="red">Rs.{{ $discount_price }}</font>
                                            @else
                                                Rs.{{ $item['product_price'] }}
                                            @endif
                                        </span></h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a>
            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach($newProducts as $new)
            @php
                $discount_price = \App\Models\Product::getDiscountPrice($new->id);
            @endphp
        <li class="span3">
            <div class="thumbnail">
                <a  href="{{ url('product/'.$new->id) }}">
                    @if(!empty($new->main_image) && file_exists('images/product_images/small/'.$new->main_image))
                    <img style="width: 100%" src="{{ URL::to('images/product_images/small/'.$new->main_image) }}" alt=""/>
                    @else
                    <img style="width: 100%" src="{{ URL::to('images/product_images/small/no_image.jpg') }}" alt=""/>
                    @endif
                </a>
                <div class="caption">
                    <h5>{{ $new->product_name }}</h5>
                    <p>
                        {{ $new->product_code }} ({{ $new->product_color }})
                    </p>

                    <h4 style="text-align:center"> <a class="btn" href="{{ url('product/'.$new->id) }}"">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">
                        @if($discount_price > 0)
                            <del>Rs.{{ $new->product_price }}</del>
                            <font color="yellow">Rs.{{ $discount_price }}</font>
                        @else
                            Rs.{{ $new->product_price }}
                        @endif
                    </a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
