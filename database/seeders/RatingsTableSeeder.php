<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratingRecord = [
            ['id'=>1,'user_id'=>1,'product_id'=>1,'review'=>'very good product','rating'=>4,'status'=>0],
            ['id'=>2,'user_id'=>1,'product_id'=>2,'review'=>'excellent product','rating'=>5,'status'=>0],
            ['id'=>4,'user_id'=>3,'product_id'=>1,'review'=>'product is not good at all','rating'=>1,'status'=>0],
        ];
        Rating::insert($ratingRecord);
    }
}
