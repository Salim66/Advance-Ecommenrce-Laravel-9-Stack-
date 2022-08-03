<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

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

                // return $catDetails; die;
                return view('front.products.ajax_products_listing', compact('catDetails', 'catProducts', 'url'));
            }else {
                abort(404);
            }

        }else {
            $url = Route::getFacadeRoot()->current()->uri(); // get current path/uri
            // echo "<pre>"; print_r($url); die;
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount > 0){
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

                $page_name = 'listing';
                // return $catDetails; die;
                return view('front.products.listing', compact('catDetails', 'catProducts', 'url', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name'));
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
        return view('front.products.detial', compact('product_detail', 'total_stock', 'related_product'));

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
    public function checkout(){
        $user_cart_items = Cart::userCartItem();
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        return view('front.products.checkout', compact('user_cart_items', 'deliveryAddresses'));
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
                'mobile' => 'required|numeric',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.alpha'  => 'Valid name is required',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric'  => 'Valid mobile is required',
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
}
