<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome To E-Commerce Website</title>
</head>
<body>
    <table style="width: 700px;">
        <tr><td>&nbsp;</td></tr>
        <tr><td><h1>ThreeSixtyDegree</h1></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hello {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your order #{{ $order_id }} status has been updated to {{ $order_status }}.</td></tr>
        @if(!empty($courier_name) && !empty($tracking_number))
        <tr><td>&nbsp;</td></tr>
        <tr><td>Courier Name is {{ $courier_name }} and Tracking Number is {{ $tracking_number }}</td></tr>
        @endif
        <tr><td>&nbsp;</td></tr>
        <tr><td> your order detials are as below:</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Order no: {{ $order_id }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width: 95%;" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                <tr color="#cccccc">
                    <td>Name</td>
                    <td>Code</td>
                    <td>Size</td>
                    <td>Color</td>
                    <td>Quantity</td>
                    <td>price</td>
                </tr>
                @foreach($orderDetials->order_products as $order)
                <tr>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->product_code }}</td>
                    <td>{{ $order->product_size }}</td>
                    <td>{{ $order->product_color }}</td>
                    <td>{{ $order->product_qty }}</td>
                    <td>{{ $order->product_price }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right">Shipping Charges</td>
                    <td>INR {{ $orderDetials->shipping_charges }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Coupon Discount</td>
                    <td>INR
                        @if($orderDetials->coupon_amount > 0)
                        {{ $orderDetials->coupon_amount }}</td>
                        @else
                            0
                        @endif
                </tr>
                <tr>
                    <td colspan="5" align="right">Grand Total</td>
                    <td>INR {{ $orderDetials->grand_total }}</td>
                </tr>
                <tr><td>&nbsp;</td></tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr>
                    <td><strong>Delivery Address</strong></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $orderDetials->name }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $orderDetials->address }}</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>{{ $orderDetials->city }}</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $orderDetials->state }}</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $orderDetials->country }}</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td>{{ $orderDetials->pincode }}</td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{ $orderDetials->mobile }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>For any enquiries, you can contact us at <a href="mailto:salimhaasnriad@gmail.com">salimhasanriad@gmail.com</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Regards, <br>Team ThreeSixtyDegree Developers</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>
