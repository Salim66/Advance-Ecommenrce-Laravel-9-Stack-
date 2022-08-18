<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrdersProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ordersData = Order::select('id','user_id', 'name', 'address', 'city', 'state', 'country', 'mobile', 'email', 'order_status', 'payment_method', 'payment_geteway', 'grand_total')->orderBy('id', 'DESC')->get();

        foreach($ordersData as $key => $value){
            // echo $value['id']; echo "<br/>";
            $ordeItems = OrdersProduct::select('id', 'product_code', 'product_name', 'product_color', 'product_size', 'product_price', 'product_qty')->where('order_id', $value['id'])->get();
            // $ordeItems = json_decode(json_encode($ordeItems));
            // echo "<pre>"; print_r($ordeItems); die;
            $product_codes = "";
            $product_names = "";
            $product_colors = "";
            $product_sizes = "";
            $product_prices = "";
            $product_quantities = "";
            foreach($ordeItems as $item){
                $product_codes .= $item['product_code'] . ",";
                $product_names .= $item['product_name'] . ",";
                $product_colors .= $item['product_color'] . ",";
                $product_sizes .= $item['product_size'] . ",";
                $product_prices .= $item['product_price'] . ",";
                $product_quantities .= $item['product_qty'] . ",";
            }
            $ordersData[$key]['product_codes'] = $product_codes;
            $ordersData[$key]['product_names'] = $product_names;
            $ordersData[$key]['product_colors'] = $product_colors;
            $ordersData[$key]['product_sizes'] = $product_sizes;
            $ordersData[$key]['product_prices'] = $product_prices;
            $ordersData[$key]['product_quantities'] = $product_quantities;
        }
        return $ordersData;
    }

    public function headings(): array{
        return ['Id', 'User_ID', 'Name', 'Address', 'City', 'State', 'Country', 'Mobile', 'Email', 'Order Status', 'Payment Method', 'payment Gateway', 'Grand Total', 'Product Codes', 'product Names', 'product Colors', 'product Sizes', 'product Prices', 'product Quantities'];
    }


}
