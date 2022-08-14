<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    @if(!empty($meta_title))
    <title>{{ $meta_title }}</title>
    @else
	<title>Stack Developers online Shopping cart</title>
    @endif

    @if(!empty($meta_description))
    <meta name="description" content="{{ $meta_description }}">
    @else
	<meta name="description" content="Three Sixty Degree E-Commerce Shipping , Selling Product in online market place.">
    @endif

    @if(!empty($meta_keyword))
    <meta name="keyword" content="{{ $meta_keyword }}">
    @else
	<meta name="keyword" content="Man, Women, Kids Cloths">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Front style -->
	<link id="callCss" rel="stylesheet" href="{{ asset('frontend/') }}/themes/css/front.min.css" media="screen"/>
	<link href="{{ asset('frontend/') }}/themes/css/base.css" rel="stylesheet" media="screen"/>
	<!-- Front style responsive -->
	<link href="{{ asset('frontend/') }}/themes/css/front-responsive.min.css" rel="stylesheet"/>
	<link href="{{ asset('frontend/') }}/themes/css/font-awesome.css" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
	<link href="{{ asset('frontend/') }}/themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="{{ asset('frontend/') }}/themes/images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('frontend/') }}/themes/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('frontend/') }}/themes/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('frontend/') }}/themes/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="{{ asset('frontend/') }}/themes/images/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
    <style>
        form.cmxform label.error, label.error {
            color: red;
            font-style: italic;
        }
    </style>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=621cb8f8b846610019d3dc86&product=inline-share-buttons' async='async'></script>
</head>
<body>
@include('layouts.front_layout.front_header')
<!-- Header End====================================================================== -->
@include('front.banner.home_page_banner')
<div id="mainBody">
	<div class="container">
		<div class="row">
			<!-- Sidebar ================================================== -->
            @include('layouts.front_layout.front_sidebar')
			<!-- Sidebar end=============================================== -->
            @section('content')
            @show
		</div>
	</div>
</div>
<!-- Footer ================================================================== -->
@include('layouts.front_layout.front_footer')
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="{{ asset('frontend/') }}/themes/js/jquery.js" type="text/javascript"></script>
<script src="{{ asset('frontend/') }}/themes/js/jquery.validate.js" type="text/javascript"></script>
<script src="{{ asset('frontend/') }}/themes/js/front.min.js" type="text/javascript"></script>
<script src="{{ asset('frontend/') }}/themes/js/google-code-prettify/prettify.js"></script>

<script src="{{ asset('frontend/') }}/themes/js/front.js"></script>
<script src="{{ asset('frontend/') }}/themes/js/front_scripts.js"></script>
<script src="{{ asset('frontend/') }}/themes/js/jquery.lightbox-0.5.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-62f92c34c64d77f2"></script>
</body>
</html>
