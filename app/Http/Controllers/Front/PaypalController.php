<?php

namespace App\Http\Controllers\Front;

use App\Models\Sms;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    /**
     * @access private
     * @route /paypal
     * @method GET
     */
    public function paypal(){
        if(Session::get('order_id')){
            $orderDetails = Order::where('id', Session::get('order_id'))->first()->toArray();
            $nameArr = explode(' ', $orderDetails['name']);
            return view('front.paypal.paypal', compact('orderDetails', 'nameArr'));
        }else {
            return redirect('/cart');
        }
    }

    /**
     * @access private
     * @route /paypal/success
     * @method GET
     */
    public function success(){
        if(Session::get('order_id')){

            // Get Order details
            $orderDetails = Order::with('order_products')->where('id', Session::get('order_id'))->first();

            // Update product quantity after successfully placed order by customer
            foreach($orderDetails->order_products as $item){
                // Current product stock
                $getProductStock = ProductAttribute::where(['product_id'=>$item->product_id, 'size'=>$item->product_size])->first()->toArray();
                // Calculate new stock
                $newStock = $getProductStock['stock'] - $item->product_qty;
                //Update product stock
                ProductAttribute::where(['product_id'=>$item->product_id, 'size'=>$item->product_size])->update(['stock'=>$newStock]);
            }

            // Empty the user cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.paypal.success');
        }else {
            return redirect('/cart');
        }
    }

    /**
     * @access private
     * @route /paypal/fail
     * @method GET
     */
    public function fail(){
        return view('front.paypal.fail');
    }

    /**
     * @access private
     * @route /paypal/ipn
     * @method GET
     */
    public function ipn(Request $request){
        $data = $request->all();
        $data['payment_status'] = "Completed";
        if($data['payment_status'] == "Completed"){

            $order_id = Session::get('order_id');

            // Update order status to paid
            Order::where('id', $order_id)->update(['order_status' => 'Paid']);

            // Send Order SMS
            $message = "Dear Customer, your order ".$order_id." has been successfully placed with ThreeSixtyDegree. We will intimate you once your order is shipped.";
            $mobile = Auth::user()->mobile;
            Sms::sendSMS($message, $mobile);

            // Get Order details
            $orderDetails = Order::with('order_products')->where('id', $order_id)->first();

            // return $orderDetails; die;

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


        }
    }
}
