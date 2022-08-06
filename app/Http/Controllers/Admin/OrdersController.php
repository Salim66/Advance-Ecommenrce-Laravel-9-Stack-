<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sms;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdersLog;
use Illuminate\Support\Facades\Mail;
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
        $odersLog = OrdersLog::where('order_id', $id)->orderBy('id', 'DESC')->get();
        // dd($orderStatuses);
        return view('admin.orders.order_details', compact('orderDetails', 'customerDetials', 'orderStatuses', 'odersLog'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){

            $data = $request->all();

            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);

            Session::put('success_message', 'Order Status updated has been successfully');

            // Get Delivery Details
            $deliveryDetails = Order::select('mobile', 'email', 'name')->where('id', $data['order_id'])->first();

            // Send order status update SMS
            $message = "Dear Customer, your order #".$data['order_id']." status has been updated to".$data['order_status']. " placed with ThreeSixtyDegree.";
            $mobile = $deliveryDetails->mobile;
            Sms::sendSMS($message, $mobile);

            // Get Order details
            $orderDetails = Order::with('order_products')->where('id', $data['order_id'])->first();


            // Send Order status update Email
            $email = $deliveryDetails->email;
            $messageData = [
                'email' => $email,
                'name' => $deliveryDetails->name,
                'order_id' => $data['order_id'],
                'order_status' => $data['order_status'],
                'orderDetials' => $orderDetails
            ];

            Mail::send('emails.order_status', $messageData,function($message) use($email){
                $message->to($email)->subject('Order Status Updated --- ThreeSixtyDegree');
            });

            // Update Order Log
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            return redirect()->back();

        }
    }


}
