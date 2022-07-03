<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    /**
     * Category Add Edit Method
     */
    public function addEditCategory(Request $request, $id=null){
        if($id == ""){
            $title = 'Add Category';
            //Add Category Functionality
        }else {
            $title = 'Edit Category';
            //Edit Category Functionality
        }

        $all_section = Section::all();

        return view('admin.categories.add_edit_category', compact('title', 'all_section'));
    }
}
