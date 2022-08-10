<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsPagesRecord = [
            ['id'=>1,'title'=>'About Us','description'=>'Content is comming soon....','url'=>'about-us','meta_title'=>'About Us','meta_description'=>'CMS Pages --- About Us Page','meta_keyword'=>'Test Purpose About us page','status'=>1],
            ['id'=>2,'title'=>'Privecy Policy','description'=>'Content is comming soon....','url'=>'privecy-policy','meta_title'=>'Privecy Policy','meta_description'=>'CMS Pages --- Privecy Policy Page','meta_keyword'=>'Test Purpose Privecy Policy page','status'=>1],
        ];

        CmsPage::insert($cmsPagesRecord);
    }
}
