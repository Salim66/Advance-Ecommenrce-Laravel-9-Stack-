<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
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
}
