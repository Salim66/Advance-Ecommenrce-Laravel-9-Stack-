<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    /**
     * All Brands
     */
    public function brands(){
        Session::put('page', 'brands');
        $all_data = Brand::all();
        return view('admin.brands.brands', compact('all_data'));
    }

    /**
     * Update Brand Status
     */
    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'brand_id' => $data['brand_id']
            ]);
        }
    }

    /**
     * Add / Edit Brand
     */
    public function addEditBrand(Request $request, $id=null){
        if($id==""){
            $title = 'Add Brand';
            $brand_data = new Brand;
            $message = "Brand added successfully";
        }else {
            $title = 'Edit Brand';
            $brand_data = Brand::find($id);
            $message = "Brand updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'brand_name.required' => 'Name is required',
                'brand_name.alpha'  => 'Valid name is required',
            ];
            $this->validate($request, $rules, $customMessage);

            $brand_data->name = $data['brand_name'];
            $brand_data->save();

            Session::flash('success_message', $message);
            return redirect('admin/brands');

        }

        return view('admin.brands.add_edit_brand', compact('brand_data', 'title'));
    }

    /**
     * Delete Brand
     */
    public function deleteBrand($id){
        $brand_data = Brand::findOrFail($id);

        $brand_data->delete();

        Session::put('success_message', 'Brand Deleted Successfully ):');
        return redirect()->back();
    }
}
