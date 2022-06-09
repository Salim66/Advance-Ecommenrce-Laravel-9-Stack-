<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $adminRecord = [
            'id' => 1,
            'name' => 'admin',
            'type' => 'admin',
            'mobile' => '01773980593',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), //password
            'image' => '',
            'status' => 1
        ];

        Admin::create($adminRecord);
        
    }
}
