<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdersLog;
use App\Models\OrdersProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * @access private
     * @route /orders
     * @method GET
     */
    public function orders(){
        $orders = Order::with('order_products')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        // dd($orders); die;
        return view('front.orders.orders', compact('orders'));
    }

    /**
     * @access private
     * @rotue /order-details
     * @method GET
     */
    public function orderDetials($id){
        $orderDetails = Order::with('order_products')->where('id', $id)->first();
        // dd($orderDetails);
        return view('front.orders.order_details', compact('orderDetails'));
    }

    /**
     * @access private
     * @routes /orders/{id}/cancel
     * @method ANY
     */
    public function cancelOrder(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();

            // Get user id from auth
            $user_id_auth = Auth::user()->id;

            // Get user id from orders table
            $user_id_order = Order::select('user_id')->where('id', $id)->first();

            if($user_id_auth == $user_id_order->user_id){
                //Update order status to cancel
                Order::where('id', $id)->update(['order_status'=>'Cancelled']);

                // Update order log
                $log = new OrdersLog;
                $log->order_id = $id;
                $log->order_status = "Cancelled";
                $log->reason = $data['reason'];
                $log->updated_by = "User";
                $log->save();

                $message = "Oder has been Cancelled";
                Session::put('success_message', $message);
                return redirect()->back();
            }else {
                $message = "Your order Cancelled request is not valid";
                Session::put('error_message', $message);
                return redirect()->back();
            }
        }

    }

    /**
     * @access private
     * @routes /orders/{id}/return
     * @method ANY
     */
    public function returnOrder(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();

            // Get user id from auth
            $user_id_auth = Auth::user()->id;

            // Get user id from orders table
            $user_id_order = Order::select('user_id')->where('id', $id)->first();

            if($user_id_auth == $user_id_order->user_id){

                // Get Product Details
                $productArr = explode('-', $data['product_info']);
                $product_code = $productArr[0];
                $product_size = $productArr[1];

                //Update Item Status
                OrdersProduct::where(['order_id'=>$id, 'product_code'=>$product_code, 'product_size'=>$product_size])->update(['item_status'=>'Return Initiated']);

                // Update order return
                $return = new ReturnRequest;
                $return->order_id = $id;
                $return->user_id = $user_id_auth;
                $return->product_size = $product_size;
                $return->product_code = $product_code;
                $return->return_reason = $data['return_reason'];
                $return->return_status = "Pending";
                $return->comment = $data['comment'];
                $return->save();

                $message = "Return request has been placed for the ordered product.";
                Session::put('success_message', $message);
                return redirect()->back();
            }else {
                $message = "Your order return request is not valid";
                Session::put('error_message', $message);
                return redirect()->back();
            }
        }

    }

    /**
     * @access private
     * @routes /get-product-sizes
     * @method POST
     */
    public function getProductSizes(Request $request){
        if($request->ajax()){
            $data = $request->all();

            // Get product details
            $productArr = explode('-', $data['product_info']);
            $product_code = $productArr[0];
            $product_size = $productArr[1];

            $proudctid = Product::select('id')->where('product_code', $product_code)->first();
            $product_id = $proudctid->id;
            $productSizes = ProductAttribute::select('size')->where('product_id', $product_id)->where('size', '!=', $product_size)->where('stock', '>', 0)->get();

            $appendSizes = "<option value=''>Select Required Size</option>";
            foreach($productSizes as $size){
                $appendSizes .= "<option value='.$size->size.'>".$size->size."</option>";
            }
            return $appendSizes;

        }
    }
}
