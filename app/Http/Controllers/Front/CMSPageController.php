<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CMSPageController extends Controller
{
    /**
     * CMSPage 
     */
    public function cmsPage(){
        $currentRoute = url()->current();
        $currentRoute = str_replace('http://localhost:8000/','', $currentRoute);
        $cmsRoute = CmsPage::where('status', 1)->get()->pluck('url')->toArray();
        if(in_array($currentRoute, $cmsRoute)){
            $cmsPageDetails = CmsPage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.cms_page', compact('cmsPageDetails'));
        }
    }
}
