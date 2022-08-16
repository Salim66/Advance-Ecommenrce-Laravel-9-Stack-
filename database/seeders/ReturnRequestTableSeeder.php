<?php

namespace Database\Seeders;

use App\Models\ReturnRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $returnRequestRecord = [
            ['id'=>1,'order_id'=>9,'user_id'=>12,'product_id'=>1,'product_code'=>'BT0011','return_reason'=>'Item arrived too late', 'return_status'=>'Pending','comment'=>'']
        ];
        ReturnRequest::insert($returnRequestRecord);
    }
}
