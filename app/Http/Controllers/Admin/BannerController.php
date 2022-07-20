<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

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
     * Add Edit Banner
     */
    public function addEditBanner(Request $request, $id = null){
        if($id == ""){
            // Add Banner
            $title = "Add Banner Image";
            $banner_data = new Banner;
            $message = "Banner Added Successfully";
        }else {
            // Edit Banner
            $title = "Edit Banner Image";
            $banner_data = Banner::find($id);
            $message = "Banner Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $banner_image = "";
            // Upload Banner Image
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    // Get orginal image name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = $image_name . '-'. rand(111,9999) . '.' . $extension;
                    // Set path
                    $image_path = 'images/banner_images/' . $imageName;
                    // Upload image after resize
                    Image::make($image_tmp)->resize(1170,480)->save($image_path);
                    // Save banner image in banner table
                    $banner_image = $imageName;
                }
            }else {
                $banner_image = $banner_data->image;
            }

            $banner_data->image = $banner_image;
            $banner_data->title = $data['title'];
            $banner_data->link = $data['link'];
            $banner_data->alt = $data['alt'];
            $banner_data->save();

            Session::flash('success_message', $message);
            return redirect('admin/banners');
        }



        return view('admin.banners.add_edit_banner', compact('title', 'banner_data'));
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
