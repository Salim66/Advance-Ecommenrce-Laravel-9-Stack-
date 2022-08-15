<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wishlistRecords = [
            ['id'=>1,'user_id'=>12,'product_id'=>1],
            ['id'=>2,'user_id'=>12,'product_id'=>2],
        ];
        Wishlist::insert($wishlistRecords);
    }
}
