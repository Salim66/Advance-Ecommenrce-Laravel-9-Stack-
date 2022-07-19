<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    /**
     * All Banner
     */
    public function banners(){
        Session::put('page', 'banners');
        $all_data = Banner::all();
        return view('admin.banners.banners', compact('all_data'));
    }


    /**
     * Update Banner Status
     */
    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'banner_id' => $data['banner_id']
            ]);
        }
    }

    /**
     * Delete Banner
     */
    public function deleteBanner($id){
        $banner_data = Banner::findOrFail($id);

        if(file_exists('images/banner_images/'.$banner_data->image) && !empty($banner_data->image)){
            unlink('images/banner_images/'.$banner_data->image);
        }

        $banner_data->delete();

        Session::put('success_message', 'Banner Deleted Successfully ):');
        return redirect()->back();
    }
}
