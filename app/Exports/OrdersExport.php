<?php

namespace App\Exports;

use App\Models\Order;
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
        return $ordersData;
    }

    public function headings(): array{
        return ['Id', 'User_ID', 'Name', 'Address', 'City', 'State', 'Country', 'Mobile', 'Email', 'Order Status', 'Payment Method', 'payment Gateway', 'Grand Total'];
    }


}
