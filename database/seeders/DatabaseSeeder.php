<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(AdminsTableSeeder::class);
        // $this->call(SectionTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        // $this->call(ProductTableSeeder::class);
        // $this->call(ProductAttributeTableSeeder::class);
        // $this->call(ProductImagesTableSeeder::class);
        // $this->call(BrandTableSeeder::class);
        // $this->call(BannerTableSeeder::class);
        // $this->call(CouponsTableSeeder::class);
        // $this->call(DeliveryAddressTableSeeder::class);
        // $this->call(OrderStatusTableSeeder::class);
        // $this->call(CmsPagesTableSeeder::class);
        // $this->call(CurrencyTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
    }
}
