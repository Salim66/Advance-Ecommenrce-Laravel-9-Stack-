@php
    $sections = \App\Models\Section::section();
@endphp
<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="{{ url('cart') }}"><img src="{{ asset('frontend/') }}/themes/images/ico-cart.png" alt="cart"><span class="totalCartItems">{{ totalCartItems() }}</span> Items in your cart</a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach($sections as $section)
        @if(count($section->categories) > 0)
        <li class="subMenu"><a>{{ $section->name }}</a>
            <ul>
                @foreach($section->categories as $category)
                @php $productCount = \App\Models\Product::productCount($category->id) @endphp
                <li><a href="{{ url($category->url) }}"><i class="icon-chevron-right"></i><strong>{{ $category->category_name }} ({{ $productCount }})</strong></a></li>
                @foreach($category->subCategories as $subcat)
                @php $productCount = \App\Models\Product::productCount($subcat->id) @endphp
                <li><a href="{{ url($subcat->url) }}"><i class="icon-chevron-right"></i>{{ $subcat->category_name }} ({{ $productCount }})</a></li>
                @endforeach
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
    </ul>
    <br>
    <br>
    @if(isset($page_name) && $page_name == 'listing' && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Brand</h5>
        @foreach ($brandArray as $brand)
            <input class="brand" style="margin-top: -4px;" type="checkbox" name="brand[]" id="brand" value="{{ $brand }}">&nbsp;&nbsp;{{ $brand }}<br/>
        @endforeach
    </div>
    @endif
    @if(isset($page_name) && $page_name == 'listing' && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Fabric</h5>
        @foreach ($fabricArray as $fabric)
            <input class="fabric" style="margin-top: -4px;" type="checkbox" name="fabric[]" id="fabric" value="{{ $fabric }}">&nbsp;&nbsp;{{ $fabric }}<br/>
        @endforeach
    </div>
    @endif
    <br>
    @if(isset($page_name) && $page_name == 'listing'  && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Sleeve</h5>
        @foreach ($sleeveArray as $sleeve)
            <input class="sleeve" style="margin-top: -4px;" type="checkbox" name="sleeve[]" id="sleeve" value="{{ $sleeve }}">&nbsp;&nbsp;{{ $sleeve }}<br/>
        @endforeach
    </div>
    @endif
    <br>
    @if(isset($page_name) && $page_name == 'listing'  && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Pattern</h5>
        @foreach ($patternArray as $pattern)
            <input class="pattern" style="margin-top: -4px;" type="checkbox" name="pattern[]" id="pattern" value="{{ $pattern }}">&nbsp;&nbsp;{{ $pattern }}<br/>
        @endforeach
    </div>
    @endif
    <br>
    @if(isset($page_name) && $page_name == 'listing'  && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Fit</h5>
        @foreach ($fitArray as $fit)
            <input class="fit" style="margin-top: -4px;" type="checkbox" name="fit[]" id="fit" value="{{ $fit }}">&nbsp;&nbsp;{{ $fit }}<br/>
        @endforeach
    </div>
    @endif
    <br>
    @if(isset($page_name) && $page_name == 'listing'  && !isset($_REQUEST['search']))
    <div class="well well-small">
        <h5>Occasion</h5>
        @foreach ($occasionArray as $occasion)
            <input class="occasion" style="margin-top: -4px;" type="checkbox" name="occasion[]" id="occasion" value="{{ $occasion }}">&nbsp;&nbsp;{{ $occasion }}<br/>
        @endforeach
    </div>
    @endif
    <br/>
    <div class="thumbnail">
        <img src="{{ asset('frontend/') }}/themes/images/payment_methods.png" title="Payment Methods" alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>
