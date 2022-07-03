<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
     /**
     * All Category List
     */
    public function categories(){
        Session::put('page', 'categories');
        $all_data = Category::get();
        return view('admin.categories.categories', compact('all_data'));
    }

    /**
     * Update Category Status
     */
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'category_id' => $data['category_id']
            ]);
        }
    }
}
