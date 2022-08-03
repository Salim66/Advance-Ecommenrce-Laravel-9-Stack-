<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecord = [
            ['id'=>1,'user_id'=>1,'address'=>"Paglapir, Rangpur","city"=>'Rangpur',"state"=>"Rangpur","country"=>"Bangladesh","pincode"=>"5400","mobile"=>"01773980593","status"=>1],
            ['id'=>2,'user_id'=>1,'address'=>"Ponchogor, Thakurguay","city"=>'Rangpur',"state"=>"Rangpur","country"=>"Bangladesh","pincode"=>"5400","mobile"=>"01773980594","status"=>1]
        ];

        DeliveryAddress::insert($deliveryRecord);
    }
}
