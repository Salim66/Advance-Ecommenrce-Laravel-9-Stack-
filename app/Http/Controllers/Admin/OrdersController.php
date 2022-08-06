<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
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
        $customerDetials = User::where('id', $orderDetails->user_id)->first();
        $orderStatuses = OrderStatus::where('status', 1)->get();
        // dd($orderStatuses);
        return view('admin.orders.order_details', compact('orderDetails', 'customerDetials', 'orderStatuses'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){

            $data = $request->all();

            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);

            Session::put('success_message', 'Order Status updated has been successfully');
            return redirect()->back();

        }
    }


}
