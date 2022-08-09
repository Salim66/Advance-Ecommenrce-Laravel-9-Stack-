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
            // Empty the user cart
            // Cart::where('user_id', Auth::user()->id)->delete();
            $orderDetails = Order::where('id', Session::get('order_id'))->first()->toArray();
            $nameArr = explode(' ', $orderDetails['name']);
            return view('front.paypal.paypal', compact('orderDetails', 'nameArr'));
        }else {
            return redirect('/cart');
        }
    }
}
