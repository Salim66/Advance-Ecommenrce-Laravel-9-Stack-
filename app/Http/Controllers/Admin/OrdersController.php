<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * Orders
     */
    public function orders(){
        Session::put('page', 'orders');
        $orders = Order::with('order_products')->get();
        return view('admin.orders.orders', compact('orders'));
    }

    /**
     * Order Details
     */
    public function orderDetails($id){
        $orderDetails = Order::with('order_products')->where('id', $id)->first();
        // dd($orderDetails);
        return view('admin.orders.order_details', compact('orderDetails'));
    }
}
