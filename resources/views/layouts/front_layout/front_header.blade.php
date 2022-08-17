@php
    $sections = \App\Models\Section::section();
@endphp
<div id="header">
	<div class="container">
		<div id="welcomeLine" class="row">
			<div class="span6">Welcome!<strong> User</strong></div>
			<div class="span6">
				<div class="pull-right">
                    <input type="text" name="subscriber_email" id="subscriberEmail" placeholder="Enter email..." style="margin-top: 10px; height: 20px; width: 150px;" required><button type="button" id="subscriberButton" onclick="addSubscriber()" class="btn btn-info btn-sm">Subscribe</button>
					<a href="{{ url('cart') }}"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <span class="totalCartItems">{{ totalCartItems() }}</span> ] Items in your cart </span> </a>
				</div>
			</div>
		</div>
		<!-- Navbar ================================================== -->
		<section id="navbar">
		  <div class="navbar">
		    <div class="navbar-inner">
		      <div class="container">
		        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		        </a>
		        <a class="brand" href="{{ url('/') }}">ThreeSixtyDegree</a>
		        <div class="nav-collapse">
		          <ul class="nav">
		            <li class="active"><a href="{{ url('/') }}">Home</a></li>
		            @foreach($sections as $section)
                        @if(count($section->categories) > 0)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $section->name }} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                @foreach($section->categories as $category)
                                <li class="nav-header"><a href="{{ url($category->url) }}">{{ $category->category_name }}</a></li>
                                    @foreach($category->subCategories as $subcat)
                                    <li><a href="{{ url($subcat->url) }}">{{ $subcat->category_name }}</a></li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </li>
                        @endif
		            @endforeach
		            <li><a href="#">About</a></li>
		          </ul>
		          <form class="navbar-search pull-left" action="{{ url('/search-products') }}" method="GET">
                    @csrf
		            <input type="text" name="search" class="search-query span2" placeholder="Search"/>
                    <button type="submit">Go</button>
		          </form>
		          <ul class="nav pull-right">
                    @if(Auth::check())
		            <li><a href="{{ url('wishlist') }}">Wishlist</a></li>
                    @endif
		            <li><a href="{{ url('orders') }}">Orders</a></li>
		            <li class="divider-vertical"></li>
                    @if(Auth::check())
		            <li><a href="{{ url('account') }}">My Account</a></li>
		            <li><a href="{{ url('logout') }}">Logout</a></li>
                    @else
		            <li><a href="{{ url('login-register') }}">Login / Register</a></li>
                    @endif
		          </ul>
		        </div><!-- /.nav-collapse -->
		      </div>
		    </div><!-- /navbar-inner -->
		  </div><!-- /navbar -->
		</section>
	</div>
</div>
