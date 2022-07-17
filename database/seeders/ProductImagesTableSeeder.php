<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImagesRecord = [
            ['id'=>1,'product_id'=>1,'image'=>'001_c36-6_257527a8.webp-1133.webp','status'=>1]
        ];

        ProductImages::insert($productImagesRecord);
    }
}
