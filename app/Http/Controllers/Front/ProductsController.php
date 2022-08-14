<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\OrdersProduct;
use App\Models\OtherSetting;
use App\Models\Rating;
use App\Models\ShippingCharge;
use App\Models\Sms;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     * Listing/ Categories
     */
    public function listing(Request $request){
        Paginator::useBootstrap();
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];

            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount > 0){
                $catDetails = Category::categoryDetails($url);
                $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1);

                // If brand filter is selected
                if(isset($data['brand']) && !empty($data['brand']) == 'brand'){
                    $brandIds = Brand::select('id')->whereIn('name', $data['brand'])->pluck('id');
                    $catProducts->whereIn('products.brand_id', $brandIds);
                }

                // If fabric filter is selected
                if(isset($data['fabric']) && !empty($data['fabric']) == 'fabric'){
                    $catProducts->whereIn('products.fabric', $data['fabric']);
                }

                // If fabric sleeve is selected
                if(isset($data['sleeve']) && !empty($data['sleeve']) == 'sleeve'){
                    $catProducts->whereIn('products.sleeve', $data['sleeve']);
                }

                // If pattern is selected
                if(isset($data['pattern']) && !empty($data['pattern']) == 'pattern'){
                    $catProducts->whereIn('products.pattern', $data['pattern']);
                }

                // If fit filter is selected
                if(isset($data['fit']) && !empty($data['fit']) == 'fit'){
                    $catProducts->whereIn('products.fit', $data['fit']);
                }

                // If occasion filter is selected
                if(isset($data['occasion']) && !empty($data['occasion']) == 'occasion'){
                    $catProducts->whereIn('products.occasion', $data['occasion']);
                }


                // If sort option is selected
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort'] == 'product_latest'){
                        $catProducts->orderBy('id', 'DESC');
                    }else if($data['sort'] == 'product_name_a_z'){
                        $catProducts->orderBy('product_name', 'ASC');
                    }else if($data['sort'] == 'product_name_z_a'){
                        $catProducts->orderBy('product_name', 'DESC');
                    }else if($data['sort'] == 'price_lowest'){
                        $catProducts->orderBy('product_price', 'ASC');
                    }else if($data['sort'] == 'price_highest'){
                        $catProducts->orderBy('product_price', 'DESC');
                    }
                }else {
                    $catProducts->orderBy('id', 'DESC');
                }

                $catProducts = $catProducts->paginate(30);

                $meta_title = $catDetails['categoryDetails']['meta_title'];
                $meta_description =$catDetails['categoryDetails']['meta_description'];
                $meta_keyword = $catDetails['categoryDetails']['meta_keyword'];
                // return $catDetails; die;
                return view('front.products.ajax_products_listing', compact('catDetails', 'catProducts', 'url', 'meta_title', 'meta_description', 'meta_keyword'));
            }else {
                abort(404);
            }

        }else {
            $url = Route::getFacadeRoot()->current()->uri(); // get current path/uri
            // echo "<pre>"; print_r($url); die;
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if(isset($_REQUEST['search'])  && !empty($_REQUEST['search'])){
                $search_product = $_REQUEST['search'];
                $catDetails['breadcrumbs'] = $search_product;
                $catDetails['categoryDetails']['category_name'] = $search_product;
                $catDetails['categoryDetails']['description'] = "Search Result for ".$search_product;
                $catProducts = Product::with('brand')->join('categories', 'categories.id', '=', 'products.category_id')->select('products.*','categories.category_name')->where(function($query) use($search_product){
                    $query->where('product_name', 'like', '%'.$search_product.'%')
                    ->orWhere('products.product_code', 'like', '%'.$search_product.'%')
                    ->orWhere('products.product_color', 'like', '%'.$search_product.'%')
                    ->orWhere('products.description', 'like', '%'.$search_product.'%')
                    ->orWhere('categories.category_name', 'like', '%'.$search_product.'%');
                })->where('products.status', 1);
                $catProducts = $catProducts->get();

                $page_name = 'Search Result';
                return view('front.products.listing', compact('catDetails', 'catProducts', 'page_name'));

            }else if($categoryCount > 0){
                $catDetails = Category::categoryDetails($url);
                $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1);

                // Only for php page reload code
                // if(isset($_GET['sort']) && !empty($_GET['sort'])){
                //     if($_GET['sort'] == 'product_latest'){
                //         $catProducts->orderBy('id', 'DESC');
                //     }else if($_GET['sort'] == 'product_name_a_z'){
                //         $catProducts->orderBy('product_name', 'ASC');
                //     }else if($_GET['sort'] == 'product_name_z_a'){
                //         $catProducts->orderBy('product_name', 'DESC');
                //     }else if($_GET['sort'] == 'price_lowest'){
                //         $catProducts->orderBy('product_price', 'ASC');
                //     }else if($_GET['sort'] == 'price_highest'){
                //         $catProducts->orderBy('product_price', 'DESC');
                //     }
                // }else {
                //     $catProducts->orderBy('id', 'DESC');
                // }

                $catProducts = $catProducts->paginate(30);

                // Filter Array
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                // Get all brand
                $brandArray = Brand::select('name')->where('status', 1)->pluck('name');

                $page_name = 'listing';
                // return $catDetails; die;
                $meta_title = $catDetails['categoryDetails']['meta_title'];
                $meta_description =$catDetails['categoryDetails']['meta_description'];
                $meta_keyword = $catDetails['categoryDetails']['meta_keyword'];
                return view('front.products.listing', compact('catDetails', 'catProducts', 'url', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'brandArray', 'page_name', 'meta_title', 'meta_description', 'meta_keyword'));
            }else {
                abort(404);
            }
        }


    }

    /**
     * @access public
     * @route /product/{code}/{id}
     * @method GET
     * Product Detials page
     */
    public function detail($id){

        $product_detail = Product::with(['category', 'section', 'brand', 'attributes' => function($query){
            $query->where('status', 1);
        }, 'images'])->find($id);
        $total_stock = ProductAttribute::where('product_id', $id)->sum('stock');
        //get related product
        $related_product = Product::where('category_id', $product_detail->category_id)->where('id', '!=', $id)->inRandomOrder()->get();
        // dd($related_product);

        $groupProducts = [];
        if(!empty($product_detail->group_code)){
            $groupProducts = Product::select('id', 'main_image')->where('id', '!=', $id)->where(['group_code'=>$product_detail->group_code, 'status' => 1])->get();
        }

        // Currency Converter
        $getCurrency = Currency::select('currency_code', 'exchange_rate')->where('status', 1)->get();

        // Get all rating of product
        $ratings = Rating::with('user')->where('status', 1)->where('product_id', $id)->latest()->get();

        // Get average rating of this product
        $ratingSum = Rating::with('user')->where('status', 1)->where('product_id', $id)->sum('rating');
        $ratingCount = Rating::with('user')->where('status', 1)->where('product_id', $id)->count();


        $avgRating = round($ratingSum/$ratingCount,2);
        $avgStarRating = round($ratingSum/$ratingCount);


        $meta_title = $product_detail->product_name;
        $meta_description = $product_detail->description;
        $meta_keyword = $product_detail->product_name;
        return view('front.products.detial', compact('product_detail', 'total_stock', 'related_product', 'groupProducts', 'getCurrency', 'meta_title', 'meta_description', 'meta_keyword', 'ratings', 'avgRating', 'avgStarRating'));

    }

    /**
     * @access public
     * @route /get-product-price
     * @method POST
     */
    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'], $data['size']);

            // Currency Converter
            $getCurrency = Currency::select('currency_code', 'exchange_rate')->where('status', 1)->get();

            $getDiscountedAttrPrice['currency'] = '<span style="font-weight: normal; font-size: 14px;">';
            foreach($getCurrency as $currency){
                $getDiscountedAttrPrice['currency'] .= "<br>";
                $getDiscountedAttrPrice['currency'] .= $currency->currency_code." ";
                $getDiscountedAttrPrice['currency'] .= round($getDiscountedAttrPrice['final_price']/$currency->exchange_rate, 2);
            }
            $getDiscountedAttrPrice['currency'] .= "</span>";

            return $getDiscountedAttrPrice;
        }
    }

    /**
     * @access public
     * @route /add-to-cart
     * @method POST
     */
    public function addToCart(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if($data['quantity'] <= 0){
                $data['quantity'] = 1;
            }

            // Check product stock is available or not
            $getProductStock = ProductAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first();
            if($getProductStock->stock < $data['quantity']){
                $message = "Product quantity is not available!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            // Generate session ID if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            // Check product if already exists in User Cart
            if(Auth::check()){
                // User is logged in
                $countProduct = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id'=>Auth::user()->id])->count();
            }else {
                // User is not logged in
                $countProduct = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=>Session::get('session_id')])->count();
            }

            if($countProduct > 0){
                $message = "Product already exists in Cart!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            // Check user is logged in or not
            if(Auth::check()){
                $user_id = Auth::user()->id;
            }else {
                $user_id = 0;
            }

            // Save product in cart
            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = "Product has been added into the cart!";
            Session::flash('success_message', $message);
            return redirect('cart');

            return $data;

        }
    }

    /**
     * @access public
     * @route /cart
     * @method GET
     */
    public function cart(){
        $user_cart_items = Cart::userCartItem();
        return view('front.products.cart', compact('user_cart_items'));
    }

    /**
     * @access public
     * @route /update-cart-item-qty
     * @method POST
     */
    public function updateCartItemQty(Request $request){
        if($request->ajax()){
            $data = $request->all();

            // Get Cart Detials
            $cartDetails = Cart::where('id', $data['cartid'])->first();

            // Get available product in stock
            $availableStock = ProductAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();

            // Check stock is available or not
            if($data['qty'] > $availableStock['stock']){
                $user_cart_items = Cart::userCartItem();
                return response()->json([
                    'status' => false,
                    'message' => 'Product stock is not available',
                    'view'=>(String)View::make('front.products.cart_items', compact('user_cart_items'))
                ]);
            }

            // Check size is available
            $availableSize = ProductAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'], 'status'=>1])->count();
            if($availableSize == 0){
                $user_cart_items = Cart::userCartItem();
                return response()->json([
                    'status' => false,
                    'message' => 'Product size is not available',
                    'view'=>(String)View::make('front.products.cart_items', compact('user_cart_items'))
                ]);
            }


            Cart::where('id', $data['cartid'])->update(['quantity' => $data['qty']]);
            $user_cart_items = Cart::userCartItem();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems' => $totalCartItems,
                'view'=>(String)View::make('front.products.cart_items', compact('user_cart_items'))
            ]);
        }
    }

    /**
     * @access public
     * @route /delete-cart-item-qty
     * @method POST
     */
    public function deleteCartItem(Request $request){
        if($request->ajax()){
            $data = $request->all();

            Cart::where('id', $data['cartid'])->delete();
            $user_cart_items = Cart::userCartItem();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems' => $totalCartItems,
                'view'=>(String)View::make('front.products.cart_items', compact('user_cart_items'))
            ]);
        }
    }

    /**
     * @access public
     * @route /apply-coupon
     * @method POST
     */
    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if($couponCount == 0){
                $user_cart_items = Cart::userCartItem();
                $totalCartItems = totalCartItems();
                Session::forget('coupon_code');
                Session::forget('coupon_amount');
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon is not valid!',
                    'totalCartItems' => $totalCartItems,
                    'view' => (String)View::make('front.products.cart_items', compact('user_cart_items'))
                ]);
            }else {
                // Check for other coupon conditions

                // Get Coupon Details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                // If coupon is inactive
                if($couponDetails->status == 0){
                    $message = "This coupon is not active";
                }

                // Check If coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = "This coupon is expired!";
                }

                // Check if Coupon is for Single or Multiple Times
                if($couponDetails->coupon_type = "Single Times") {
                    // Check in order table if coupon already availed by the user
                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();
                    if($couponCount >= 1){
                        $message = "This coupon is already availed by you!";
                    }
                }

                // Check if coupon is from selected categories
                // Get all selected categories form coupon
                $catArr = explode(",", $couponDetails->categories);

                // Check any User belong to coupon facility
                if(!empty($couponDetails->users)){
                    // Check if coupon belong to logged in user
                    // Get all selected user from user
                    $userArr = explode(",", $couponDetails->users);

                    // Get user ID's of the selected user because coupon contain email
                    foreach($userArr as $user){
                        $getUserId = User::select('id')->where('email', $user)->first();
                        $userId[] = $getUserId->id;
                    }
                }


                // Get Cart Items
                $user_cart_items = Cart::userCartItem();

                // Get total cart ammount
                $total_amount = 0;

                // Check if any item belong to coupon category
                //  Check if any user belong to coupon
                foreach($user_cart_items as $item){
                    if(!in_array($item->product->category_id, $catArr)){
                        $message = "This coupon code is not for one of the selected product!";
                    }

                    if(!empty($couponDetails->users)){
                        if(!in_array($item->user_id, $userId)){
                            $message = "This coupon code is not for you!";
                        }
                    }

                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }



                if(!empty($message)){
                    $user_cart_items = Cart::userCartItem();
                    $totalCartItems = totalCartItems();
                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'view' => (String)View::make('front.products.cart_items', compact('user_cart_items'))
                    ]);
                }else {
                    // echo "coupon is successufully applied!";

                    // Check if amount type is Fixed or Percentage
                    if($couponDetails->amount_type == 'Fixed'){
                        $coupon_amount = $couponDetails->amount;
                    }else {
                        $coupon_amount = ($total_amount * $couponDetails->amount)/100;
                    }

                    $grand_total = $total_amount - $coupon_amount;

                    Session::put('coupon_amount', $coupon_amount);
                    Session::put('coupon_code', $data['code']);

                    $message = "Coupon code is successfully applied. You are availing discount !";

                    $user_cart_items = Cart::userCartItem();
                    $totalCartItems = totalCartItems();
                    return response()->json([
                        'status' => true,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'coupon_amount' => $coupon_amount,
                        'grand_total' => $grand_total,
                        'view' => (String)View::make('front.products.cart_items', compact('user_cart_items'))
                    ]);

                }

            }
        }
    }

    /**
     * @access private
     * @route /checkout
     * @method Any
     */
    public function checkout(Request $request){

        $user_cart_items = Cart::userCartItem();

        // Check cart is empty then redirect to cart
        if(count($user_cart_items) == 0){
            $message = "Shopping cart is empty. Please add product to checkout";
            Session::put('error_message', $message);
            return redirect('/cart');
        }

        $total_weight = 0;
        $total_price = 0;
        foreach($user_cart_items as $item){
            $product_weight = $item->product->product_weight;
            $total_weight = $total_weight + ($product_weight * $item->quantity);
            $get_attr_price = \App\Models\Product::getDiscountedAttrPrice($item->product->id, $item->size);
            $total_price = $total_price + ( $item->quantity * $get_attr_price['final_price'] );
        }

        $otherSettings = OtherSetting::where('id', 1)->first();

        // Check Min Cart Amount
        if($total_price < $otherSettings->min_cart_value){
            $message = "Min cart amount must be Rs. ".$otherSettings->min_cart_value;
            Session::flash('error_message', $message);
            return redirect()->back();
        }

        // Check Min Cart Amount
        if($total_price > $otherSettings->max_cart_value){
            $message = "Max cart amount must be Rs. ".$otherSettings->max_cart_value;
            Session::flash('error_message', $message);
            return redirect()->back();
        }


        $deliveryAddresses = DeliveryAddress::deliveryAddresses();

        // dd($deliveryAddresses);
        foreach($deliveryAddresses as $key => $value){
            $shippingCharges = ShippingCharge::getShippingCharges($total_weight, $value->country);
            $deliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
            // Check if delivery pincode exists in COD Pincode list
            $deliveryAddresses[$key]['codPincodeCount'] = DB::table('cod_pincodes')->where('pincode', $value->pincode)->count();
            // Check if delivery pincode exists in Prepaid pincode list
            $deliveryAddresses[$key]['prepaidPincodeCount'] = DB::table('prepaid_pincode')->where('pincode', $value->pincode)->count();
        }


        if($request->isMethod('post')){
            $data = $request->all();

            // Website security checks

            // Fetch user cart item
            foreach($user_cart_items as $key => $cart){
                //Prevent disbaled product to order
                $product_status = Product::getProductStatus($cart->product_id);
                if($product_status == 0){
                    // Product::deleteCartProduct($item->product_id);
                    $message = $item->product->product_name . " is not available so plesae remove from cart.";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }

                $product_stock = Product::getProductStock($cart->product_id, $cart->size);
                if($product_stock == 0){
                    // Product::deleteCartProduct($item->product_id);
                    $message = $item->product->product_name . " is not available so plesae remove from cart.";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }

                $getAttributeCount = Product::getAttributeCount($cart->product_id, $cart->size);
                if($getAttributeCount == 0){
                    // Product::deleteCartProduct($item->product_id);
                    $message = $item->product->product_name . " is not available so plesae remove from cart.";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }

                $getCategoryStatus = Product::getCategoryStatus($cart->product->category_id);
                if($getCategoryStatus == 0){
                    // Product::deleteCartProduct($item->product_id);
                    $message = $item->product->product_name . " is not available so plesae remove from cart.";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }
            }


            if(empty($data['address_id'])){
                $message = "Please Select Delivery Address!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            if(empty($data['payment_gateway'])){
                $message = "Please Select Payment Method!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            if($data['payment_gateway'] == "COD"){
                $payment_method = "COD";
            }else {
                $payment_method = "Prepaid";
            }

            // Get delivery address from address_id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first();

            // Get shopping charges
            $shipping_charges = ShippingCharge::getShippingCharges($total_weight, $deliveryAddress->country);

            // Calculate grand total
            $grand_total = $total_price + $shipping_charges - Session::get('coupon_amount');

            // Insert grand total in session variable
            Session::put('grand_total', $grand_total);

            DB::beginTransaction();

            // Insert order details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress->name;
            $order->address = $deliveryAddress->address;
            $order->city = $deliveryAddress->city;
            $order->state = $deliveryAddress->state;
            $order->country = $deliveryAddress->country;
            $order->pincode = $deliveryAddress->pincode;
            $order->mobile = $deliveryAddress->mobile;
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('coupon_code');
            $order->coupon_amount = Session::get('coupon_amount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_geteway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            // Get last inserted order id
            $order_id = DB::getPdo()->lastInsertId();

            // Get User Cart Items
            $cart_items = Cart::where('user_id', Auth::user()->id)->get();
            foreach($cart_items as $item){
                $ordersProduct = new OrdersProduct;
                $ordersProduct->order_id = $order_id;
                $ordersProduct->user_id = Auth::user()->id;

                // Get Product Details
                $productDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item->product_id)->first();

                $ordersProduct->product_id =  $item->product_id;
                $ordersProduct->product_code = $productDetails->product_code;
                $ordersProduct->product_name = $productDetails->product_name;
                $ordersProduct->product_color = $productDetails->product_color;
                $ordersProduct->product_size = $item->size;
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item->product_id, $item->size);
                $ordersProduct->product_price = $getDiscountedAttrPrice['final_price'];
                $ordersProduct->product_qty = $item['quantity'];
                $ordersProduct->save();

                // Update product quantity after successfully placed order by customer
                if($data['payment_gateway'] == "COD"){
                    // Current product stock
                    $getProductStock = ProductAttribute::where(['product_id'=>$item->product_id, 'size'=>$item->size])->first()->toArray();
                    // Calculate new stock
                    $newStock = $getProductStock['stock'] - $item['quantity'];
                    //Update product stock
                    ProductAttribute::where(['product_id'=>$item->product_id, 'size'=>$item->size])->update(['stock'=>$newStock]);
                }

            }

            // Insert order id in session variables
            Session::put('order_id', $order_id);

            DB::commit();

            if($data['payment_gateway'] == "COD"){

                // Send Order SMS
                $message = "Dear Customer, your order ".$order_id." has been successfully placed with ThreeSixtyDegree. We will intimate you once your order is shipped.";
                $mobile = Auth::user()->mobile;
                Sms::sendSMS($message, $mobile);

                // Get Order details
                $orderDetails = Order::with('order_products')->where('id', $order_id)->first();

                // Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetials' => $orderDetails
                ];

                Mail::send('emails.order', $messageData,function($message) use($email){
                    $message->to($email)->subject('Order Placed --- ThreeSixtyDegree');
                });

                return redirect('/thanks');
            }else if($data['payment_gateway'] == "Paypal"){
                //Paypal - Redirect user to paypal page after placing the order
                return redirect('/paypal');
            }else{
                echo "Other Prepaid method comming soon!"; die;
            }

        }



        return view('front.products.checkout', compact('user_cart_items', 'deliveryAddresses', 'total_price'));
    }

    /**
     * @access private
     * @route /thanks
     * @method GET
     */
    public function thanks(){
        if(Session::get('order_id')){
            // Empty the user cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else {
            return redirect('/cart');
        }
    }

    /**
     * @access private
     * @route /add-edit-delivery-address
     * @method any
     */
    public function addEditDeliveryAddress(Request $request, $id=null){
        if($id==""){
            $title = "Add Delivery Address";
            $address = new DeliveryAddress;
            $message = "Add delivery address successfully";
        }else {
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            $message = "Update delivery address successfully";
        }


        Session::forget('success_message');
        Session::forget('error_message');

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'country' => 'required',
                'pincode' => 'required|numeric|digits:4',
                'mobile' => 'required|numeric|digits:11',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.alpha'  => 'Valid name is required',
                'address.required' => 'Address is required',
                'city.required' => 'City name is required',
                'city.alpha'  => 'Valid city name is required',
                'state.required' => 'State name is required',
                'state.alpha'  => 'Valid state name is required',
                'country.required' => 'Country is required',
                'pincode.required' => 'Pincode is required',
                'pincode.numeric'  => 'Valid pincode is required',
                'pincode.digits'  => 'Pincode must be of 4 digits',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric'  => 'Valid mobile is required',
                'mobile.digits'  => 'Mobile must be of 11 digits',
            ];
            $this->validate($request, $rules, $customMessage);

            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->save();

            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('/checkout');

        }

        $countries = Country::all();
        return view('front.products.add_edit_delivery_address', compact('title', 'countries', 'address'));
    }

    /**
     * @access private
     * @routes /delete-delivery-address/id
     * @method GET
     */
    public function deleteDeliveryAddress($id){
        DeliveryAddress::where('id', $id)->delete();
        Session::put('success_message', "Delivery Address Delete Successfully!");
        Session::forget('error_message');
        return redirect()->back();
    }

    /**
     * @access public
     * @routes /check-pincode
     * @method POST
     */
    public function checkPincode(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if( is_numeric($data['pincode']) && $data['pincode'] > 0 && $data['pincode'] == round($data['pincode'], 0) ) {
                $codPincodeCount = DB::table('cod_pincodes')->where('pincode', $data['pincode'])->count();
                $prepaidPincodeCount = DB::table('prepaid_pincode')->where('pincode', $data['pincode'])->count();

                if($codPincodeCount == 0 && $prepaidPincodeCount == 0){
                    echo "This pincode is not available for delivery"; die;
                }else {
                    echo "This pincode is available for delivery"; die;
                }
            }else {
                echo "Please insert valid pincode!"; die;
            }
        }
    }
}
