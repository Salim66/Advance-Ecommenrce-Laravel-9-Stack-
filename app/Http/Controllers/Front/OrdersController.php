<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
