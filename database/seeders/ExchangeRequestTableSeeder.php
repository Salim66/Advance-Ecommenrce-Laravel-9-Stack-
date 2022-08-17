<?php

namespace Database\Seeders;

use App\Models\ExchangeRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exchangeRequestRecord = [
            ['id'=>1,'order_id'=>9,'user_id'=>12,'product_size'=>'Small','required_size'=>'Medium','product_code'=>'BT0011','exchange_reason'=>'Require medium size', 'exchange_status'=>'Pending','comment'=>'']
        ];
        ExchangeRequest::insert($exchangeRequestRecord);
    }
}
