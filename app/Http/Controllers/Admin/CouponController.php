<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * All Coupon
     */
    public function coupons(){
        Session::put('page', 'coupons');
        $all_data = Coupon::all();
        return view('admin.coupons.coupons', compact('all_data'));
    }

    /**
     * Add Edit Banner
     */
    public function addEditCoupon(Request $request, $id = null){
        if($id == ""){
            // Add Coupon
            $title = "Add Coupon Image";
            $coupon_data = new Coupon;
            $message = "Coupon Added Successfully";
        }else {
            // Edit Coupon
            $title = "Edit Coupon Image";
            $coupon_data = Coupon::find($id);
            $message = "Coupon Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            return $data;

        }

        // Sections with category and subcategory
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories));

        // Active all user get
        $users = User::select('email')->where('status', 1)->get();


        return view('admin.coupons.add_edit_coupon', compact('title', 'coupon_data', 'categories', 'users'));
    }


    /**
     * Update Coupon Status
     */
    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'coupon_id' => $data['coupon_id']
            ]);
        }
    }

    /**
     * Delete Banner Image
     */
    public function deleteBannerImage($id){
        $banner_data = Banner::findOrFail($id);

        // banner image deleted
        if(file_exists('images/banner_images/'.$banner_data->image) && !empty($banner_data->image)){
            unlink('images/banner_images/'.$banner_data->image);
        }

        Session::put('success_message', 'Banner Image has been Deleted successfully');
        return redirect()->back();
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
