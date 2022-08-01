<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            $selCats = [];
            $selUsers = [];
            $coupon_data = new Coupon;
            $message = "Coupon Added Successfully";
        }else {
            // Edit Coupon
            $title = "Edit Coupon Image";
            $coupon_data = Coupon::find($id);
            $selCats = explode(',', $coupon_data['categories']);
            $selUsers = explode(',', $coupon_data['users']);
            $message = "Coupon Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            // coupon validation
            $rules = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required'
            ];
            $customMessage = [
                'categories.required' => 'Category is required',
                'coupon_option.required' => 'Coupon Option is required',
                'coupon_tpye.required' => 'Coupon Type is required',
                'amount_tpye.required' => 'Amount Type is required',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Valid amount is required',
                'expiry_date.required' => 'Expiry Date is required',
            ];
            $this->validate($request, $rules, $customMessage);

            if(isset($data['users'])){
                $users = implode(',', $data['users']);
            }else {
                $users = "";
            }

            if(isset($data['categories'])){
                $categories = implode(',', $data['categories']);
            }

            if($data['coupon_option'] == 'Automatic'){
                $coupon_code = Str::random(8);
            }else {
                $coupon_code = $data['coupon_code'];
            }

            $coupon_data->coupon_option = $data['coupon_option'];
            $coupon_data->coupon_code = $coupon_code;
            $coupon_data->coupon_type = $data['coupon_type'];
            $coupon_data->amount_type = $data['amount_type'];
            $coupon_data->amount = $data['amount'];
            $coupon_data->categories = $categories;
            $coupon_data->users = $users;
            $coupon_data->expiry_date = $data['expiry_date'];
            $coupon_data->status = 1;
            $coupon_data->save();

            Session::flash('success_message', $message);
            return redirect('admin/coupons');
        }

        // Sections with category and subcategory
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories));

        // Active all user get
        $users = User::select('email')->where('status', 1)->get();


        return view('admin.coupons.add_edit_coupon', compact('title', 'coupon_data', 'categories', 'users', 'selCats', 'selUsers'));
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
