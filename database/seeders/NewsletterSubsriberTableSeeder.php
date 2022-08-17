<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterSubsriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsletterRecord = [
            ['id'=>1,'email'=>'salim111222@yopmail.com','status'=>1],
            ['id'=>2,'email'=>'user@yopmail.com','status'=>1],
        ];
        NewsletterSubscriber::insert($newsletterRecord);
    }
}
