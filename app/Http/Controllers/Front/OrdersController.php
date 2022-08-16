<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdersLog;
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
     * @method GET
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
}
