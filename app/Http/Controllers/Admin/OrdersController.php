<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Sms;
use App\Models\User;
use App\Models\Order;
use App\Models\AdminRole;
use App\Models\OrdersLog;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\OrdersProduct;
use App\Models\ReturnRequest;
use App\Models\ExchangeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * Orders
     */
    public function orders(){
        Session::put('page', 'orders');
        $orders = Order::with('order_products')->orderBy('id', 'DESC')->get();

         // Set Admins/Subadmins Permission for Orders
         $orderModuleCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'orders'])->count();
         if(Auth::guard('admin')->user()->type == 'super admin'){
            $orderModule['view_access'] = 1;
            $orderModule['edit_access'] = 1;
            $orderModule['full_access'] = 1;
         }else if($orderModuleCount == 0){
             $message = "This feature restricted for you!";
             Session::flash('error_message', $message);
             return redirect('admin/dashboard');
         }else {
             $orderModule = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'orders'])->first()->toArray();
         }

        return view('admin.orders.orders', compact('orders', 'orderModule'));
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

            // Update Courier Name and Tracking Number
            if(!empty($data['courier_name']) && !empty($data['tracking_number'])){
                Order::where('id', $data['order_id'])->update([
                    'courier_name' => $data['courier_name'],
                    'tracking_number' => $data['tracking_number']
                ]);
            }

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
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number'],
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

    /**
     * View order invoice
     */
    public function viewOrderInvoice($id){
        $orderDetails = Order::with('order_products')->where('id', $id)->first();
        $customerDetials = User::where('id', $orderDetails->user_id)->first();
        return view('admin.orders.order_invoice', compact('orderDetails', 'customerDetials'));
    }

    /**
     * Print PDF invoice
     */
    public function printPDFInvoice($id){
        $orderDetails = Order::with('order_products')->where('id', $id)->first();
        $customerDetials = User::where('id', $orderDetails->user_id)->first();

        $output = '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Order PDF Invoice</title>
                <style>
                    @font-face {
                        font-family: SourceSansPro;
                        src: url(SourceSansPro-Regular.ttf);
                    }

                    .clearfix:after {
                        content: "";
                        display: table;
                        clear: both;
                    }

                    a {
                        color: #0087C3;
                        text-decoration: none;
                    }

                    body {
                        position: relative;
                        width: 21cm;
                        height: 29.7cm;
                        margin: 0 auto;
                        color: #555555;
                        background: #FFFFFF;
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        font-family: SourceSansPro;
                    }

                    header {
                        padding: 10px 0;
                        margin-bottom: 20px;
                        border-bottom: 1px solid #AAAAAA;
                    }

                    #logo {
                        float: left;
                        margin-top: 8px;
                    }

                    #logo img {
                        height: 70px;
                    }

                    #company {
                        float: right;
                        text-align: right;
                    }


                    #details {
                        margin-bottom: 50px;
                    }

                    #client {
                        padding-left: 6px;
                        border-left: 6px solid #0087C3;
                        float: left;
                    }

                    #client .to {
                        color: #777777;
                    }

                    h2.name {
                        font-size: 1.4em;
                        font-weight: normal;
                        margin: 0;
                    }

                    #invoice {
                        float: right;
                        text-align: right;
                    }

                    #invoice h1 {
                        color: #0087C3;
                        font-size: 2.4em;
                        line-height: 1em;
                        font-weight: normal;
                        margin: 0  0 10px 0;
                    }

                    #invoice .date {
                        font-size: 1.1em;
                        color: #777777;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        border-spacing: 0;
                        margin-bottom: 20px;
                    }

                    table th,
                    table td {
                        padding: 20px;
                        background: #EEEEEE;
                        text-align: center;
                        border-bottom: 1px solid #FFFFFF;
                    }

                    table th {
                        white-space: nowrap;
                        font-weight: normal;
                    }

                    table td {
                        text-align: right;
                    }

                    table td h3{
                        color: #57B223;
                        font-size: 1.2em;
                        font-weight: normal;
                        margin: 0 0 0.2em 0;
                    }

                    table .no {
                        color: #FFFFFF;
                        font-size: 1.6em;
                        background: #57B223;
                    }

                    table .desc {
                        text-align: left;
                    }

                    table .unit {
                        background: #DDDDDD;
                    }

                    table .qty {
                    }

                    table .total {
                        background: #57B223;
                        color: #FFFFFF;
                    }

                    table td.unit,
                    table td.qty,
                    table td.total {
                        font-size: 1.2em;
                    }

                    table tbody tr:last-child td {
                        border: none;
                    }

                    table tfoot td {
                        padding: 10px 20px;
                        background: #FFFFFF;
                        border-bottom: none;
                        font-size: 1.2em;
                        white-space: nowrap;
                        border-top: 1px solid #AAAAAA;
                    }

                    table tfoot tr:first-child td {
                        border-top: none;
                    }

                    table tfoot tr:last-child td {
                        color: #57B223;
                        font-size: 1.4em;
                        border-top: 1px solid #57B223;

                    }

                    table tfoot tr td:first-child {
                        border: none;
                    }

                    #thanks{
                        font-size: 2em;
                        margin-bottom: 50px;
                    }

                    #notices{
                        padding-left: 6px;
                        border-left: 6px solid #0087C3;
                    }

                    #notices .notice {
                        font-size: 1.2em;
                    }

                    footer {
                        color: #777777;
                        width: 100%;
                        height: 30px;
                        position: absolute;
                        bottom: 0;
                        border-top: 1px solid #AAAAAA;
                        padding: 8px 0;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <header class="clearfix">
                <div id="logo">
                    <h1>ORDER INVOICE</h1>
                </div>
                </div>
                </header>
                <main>
                <div id="details" class="clearfix">
                    <div id="client">
                    <div class="to">INVOICE TO:</div>
                    <h2 class="name">'.$orderDetails->name.'</h2>
                    <div class="address">'.$orderDetails->address.','.$orderDetails->city.','.$orderDetails->state.'</div>
                    <div class="address">'.$orderDetails->country.'-'.$orderDetails->pincode.'</div>
                    <div class="email"><a href="mailto:'.$orderDetails->email.'">'.$orderDetails->email.'</a></div>
                    </div>
                    <div id="invoice">
                    <h1>INVOICE ID '.$orderDetails->id.'</h1>
                    <div class="date">Order Date: '.date('d/m/Y', strtotime($orderDetails->created_at)).'</div>
                    <div class="date">Order Amount: '.$orderDetails->grand_total.'</div>
                    <div class="date">Order Status: '.$orderDetails->order_status.'</div>
                    <div class="date">Payment Method: '.$orderDetails->payment_method.'</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="no">Product Code</th>
                        <th class="desc">Size</th>
                        <th class="unit">Color</th>
                        <th class="desc">price</th>
                        <th class="unit">QUANTITY</th>
                        <th class="total">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>';
                        $subTotal = 0;
                      foreach($orderDetails->order_products as $product){
                    $output .='<tr>
                        <td class="no">'.$product->product_code.'</td>
                        <td class="desc">'.$product->product_size.'</td>
                            <td class="unit">'.$product->product_color.'</td>
                            <td class="desc">INR '.$product->product_price.'</td>
                        <td class="unit">'.$product->product_qty.'</td>
                        <td class="total">INR '.$product->product_price * $product->product_qty.'</td>
                    </tr>';
                        $subTotal = $subTotal + ($product->product_price * $product->product_qty);
                      }

                    $output .='</tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">SUBTOTAL</td>
                        <td>INR '.$subTotal.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">Shipping Charges</td>
                        <td>INR 0</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">Coupon Amount</td>';
                        if($orderDetails->coupon_amount > 0){
                            $output .='<td>INR '.$orderDetails->coupon_amount.'</td>';
                        }else {
                            $output .='<td>INR 0</td>';

                        }
                    $output .='</tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td>INR '.$orderDetails->grand_total.'</td>
                    </tr>
                    </tfoot>
                </table>
                <div id="thanks">Thank you!</div>
                <div id="notices">
                    <div>NOTICE:</div>
                    <div class="notice">Your Notice Will Come Here.</div>
                </div>
                </main>
                <footer>
                Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </body>
        </html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();


        // return view('admin.orders.order_invoice', compact('orderDetails', 'customerDetials'));
    }

    /**
     * View Orders Charts Report
     */
    public function viewOrdersCharts(){
        $current_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $before_1_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $before_2_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        $before_3_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3))->count();
        $orderCount = [$current_month_orders, $before_1_month_orders, $before_2_month_orders, $before_3_month_orders];
        return view('admin.orders.view_orders_charts', compact('orderCount'));
    }

    /**
     * Return Request
     */
    public function returnRequest(){
        Session::put('page', 'return_request');
        $return_request = ReturnRequest::get();
        return view('admin.orders.return_request', compact('return_request'));
    }

    /**
     * Return Request Update
     */
    public function returnRequestUpdate(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // Get return details
            $returnDetails = ReturnRequest::where('id', $data['return_id'])->first()->toArray();

            // Update return status in return request table
            ReturnRequest::where('id', $data['return_id'])->update(['return_status'=>$data['return_status']]);

            // Update return status in order products table
            OrdersProduct::where(['order_id'=>$returnDetails['order_id'],'product_code'=>$returnDetails['product_code'], 'product_size'=>$returnDetails['product_size']])->update(['item_status'=> 'Return '.$returnDetails['return_status']]);

            // Get user detials
            $userDetails = User::select('name','email')->where('id', $returnDetails['user_id'])->first()->toArray();

            // Send Return Status Email
            $email = $userDetails['email'];
            $return_status = $data['return_status'];
            $messageData = ['userDetials'=>$userDetails, 'returnDetails'=>$returnDetails, 'return_status'=>$return_status];
            Mail::send('emails.return_request', $messageData, function($message) use($email, $return_status){
                $message->to($email)->subject("Return Request ".$return_status);
            });

            $message = "Return request has been ".$return_status." and email send to user.";
            Session::flash('success_message', $message);
            return redirect('/admin/return-request');
        }
    }

    /**
     * Exchange Request
     */
    public function exchangeRequest(){
        Session::put('page', 'exchange_request');
        $exchange_request = ExchangeRequest::get();
        return view('admin.orders.exchange_request', compact('exchange_request'));
    }


    /**
     * Exchange Request Update
     */
    public function exchnageRequestUpdate(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // Get exchange details
            $exchangeDetails = ExchangeRequest::where('id', $data['exchange_id'])->first()->toArray();

            // Update exchange status in exchange request table
            ExchangeRequest::where('id', $data['exchange_id'])->update(['exchange_status'=>$data['exchange_status']]);

            // Update exchange status in order products table
            OrdersProduct::where(['order_id'=>$exchangeDetails['order_id'],'product_code'=>$exchangeDetails['product_code'], 'product_size'=>$exchangeDetails['product_size']])->update(['item_status'=> 'Exchange '.$exchangeDetails['exchange_status']]);

            // Get user detials
            $userDetails = User::select('name','email')->where('id', $exchangeDetails['user_id'])->first()->toArray();

            // Send Exchange Status Email
            $email = $userDetails['email'];
            $exchange_status = $data['exchange_status'];
            $messageData = ['userDetials'=>$userDetails, 'exchangeDetails'=>$exchangeDetails, 'exchange_status'=>$exchange_status];
            Mail::send('emails.exchange_request', $messageData, function($message) use($email, $exchange_status){
                $message->to($email)->subject("Return Request ".$exchange_status);
            });

            $message = "Exchange request has been ".$exchange_status." and email send to user.";
            Session::flash('success_message', $message);
            return redirect('/admin/exchange-request');
        }
    }

    /**
     * Export Orders
     */
    public function ordersExport(){
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }



}
