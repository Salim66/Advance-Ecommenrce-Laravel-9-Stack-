@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active"><?php echo $catDetails['breadcrumbs'] ?></li>
    </ul>
    <h3> {{ $catDetails['categoryDetails']['category_name'] }} <small class="pull-right"> {{ count($catProducts) }} products are available </small></h3>
    <hr class="soft"/>
    <p>
        {{ $catDetails['categoryDetails']['description'] }}
    </p>
    <hr class="soft"/>
    <form class="form-horizontal span6" id="sortProrduct">
        <div class="control-group">
            <input type="hidden" name="url" id="url" value="{{ $url }}">
            <label class="control-label alignL">Sort By </label>
            <select name="sort" id="sort">
                <option value="">Select</option>
                <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort'] == 'product_latest') selected @endif>Latest Product</option>
                <option value="product_name_a_z" @if(isset($_GET['sort']) && $_GET['sort'] == 'product_name_a_z') selected @endif>Product name A - Z</option>
                <option value="product_name_z_a" @if(isset($_GET['sort']) && $_GET['sort'] == 'product_name_z_a') selected @endif>Product name Z - A</option>
                <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort'] == 'price_lowest') selected @endif>Lowest Price Fist</option>
                <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort'] == 'price_highest') selected @endif>Highest Price First</option>
            </select>
        </div>
    </form>

    <div id="myTab" class="pull-right">
        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
    </div>
    <br class="clr"/>
    <div class="tab-content filter_products">
        @include('front.products.ajax_products_listing')
    </div>
    <a href="compare.html" class="btn btn-large pull-right">Compare Product</a>
    <div class="pagination">
        @if(isset($_GET['sort']) && !empty($_GET['sort']))
            {{ $catProducts->appends(['sort' => $_GET['sort']])->links() }}
        @else
            {{ $catProducts->links() }}
        @endif
    </div>
    <br class="clr"/>
</div>
@endsection
