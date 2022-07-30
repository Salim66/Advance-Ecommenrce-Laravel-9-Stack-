<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords = [
            ['id'=>1,'coupon_option'=>'Manual','coupon_code'=>'test10','categories'=>'1,2','users'=>'salim100@yopmail.com,salim1000@yopmail.com','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>10,'expiry_date'=>'2022-7-30','status'=>1]
        ];
        Coupon::insert($couponRecords);
    }
}
