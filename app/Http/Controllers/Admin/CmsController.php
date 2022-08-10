<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CmsController extends Controller
{
    /**
     * CMS Pages
     */
    public function cmsPages(){
        Session::put('page','cmspage');
        $cmsPages = CmsPage::all();
        return view('admin.pages.cms_pages', compact('cmsPages'));
    }

    /**
     * Update cms page status
     */
    public function updateCmsPagetatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'page_id' => $data['page_id']
            ]);
        }
    }
}
