<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # {{ $orderDetails->id }}</h3>
                <br>
                <span class="pull-right">
                    <?php echo DNS1D::getBarcodeHTML($orderDetails->id, 'C39'); ?>
                </span><br>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    					{{ $customerDetials->name }}<br>
                        @if(!empty($customerDetials->address))
    					{{ $customerDetials->address }}<br>
                        @endif
                        @if(!empty($customerDetials->city))
    					{{ $customerDetials->city }}<br>
                        @endif
                        @if(!empty($customerDetials->state))
    					{{ $customerDetials->state }}<br>
                        @endif
                        @if(!empty($customerDetials->country))
    					{{ $customerDetials->country }}<br>
                        @endif
                        @if(!empty($customerDetials->pincode))
    					{{ $customerDetials->pincode }}<br>
                        @endif
                        @if(!empty($customerDetials->mobile))
    					{{ $customerDetials->mobile }}<br>
                        @endif
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                    {{ $orderDetails->name }}<br>
                    {{ $orderDetails->address }}, {{ $orderDetails->city }}<br>
                    {{ $orderDetails->state }}<br>
                    {{ $orderDetails->country }}, {{ $orderDetails->pincode }}<br>
                    {{ $orderDetails->mobile }}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orderDetails->payment_method }}<br>
    					{{ $customerDetials->email }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ date('F d,Y', strtotime($orderDetails->created_at)) }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                @php $sub_total = 0; @endphp
    							@foreach($orderDetails->order_products as $product)
    							<tr>
    								<td>
                                        {{ $product->product_name }}<br/>
                                        {{ $product->product_code }}<br/>
                                        {{ $product->product_size }}<br/>
                                        {{ $product->product_color }}<br/>
                                        <?php echo DNS1D::getBarcodeHTML($product->product_name, 'C39'); ?>
                                    </td>
    								<td class="text-center">INR {{ $product->product_price }}</td>
    								<td class="text-center">{{ $product->product_qty }}</td>
                                    <td class="text-right">INR {{ $product->product_price * $product->product_qty }}</td>
    							</tr>
                                @php
                                    $sub_total = $sub_total + ($product->product_price * $product->product_qty);
                                @endphp
                                @endforeach
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Sub Total</td>
    								<td class="thick-line text-right">INR {{ $sub_total }}</strong></td>
    							</tr>
                                @if(!empty($orderDetails->coupon_amount))
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Discount</strong></td>
    								<td class="no-line text-right">INR {{ $orderDetails->coupon_amount }}</td>
    							</tr>
                                @endif
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Shipping Charges</strong></td>
    								<td class="no-line text-right">INR {{ $orderDetails->shipping_charges }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>GST Charges</strong></td>
    								<td class="no-line text-right">INR {{ $orderDetails->gst_charges }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Grand Total</strong></td>
    								<td class="no-line text-right">INR {{ $orderDetails->grand_total }}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
