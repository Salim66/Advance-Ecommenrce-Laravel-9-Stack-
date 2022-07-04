<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Image;

class CategoryController extends Controller
{
     /**
     * All Category List
     */
    public function categories(){
        Session::put('page', 'categories');
        $all_data = Category::with(['section','parentCategory'])->get();
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

        // Add Category
        if($request->isMethod('post')){

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
                'category_image' => 'image',
            ];
            $customMessage = [
                'category_name.required' => 'Name is required',
                'category_name.alpha'  => 'Valid name is required',
                'section_id.required' => 'Section is required',
                'url.required' => 'URL is required',
                'category_image.image'  => 'Valid image is required'
            ];
            $this->validate($request, $rules, $customMessage);

            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //Generate new image name
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);
                }
            }

            Category::create([
                'parent_id' => $request->parent_id,
                'section_id' => $request->section_id,
                'category_name' => $request->category_name,
                'category_image' => $imageName,
                'category_discount' => $request->category_discount,
                'description' => $request->description,
                'url' => $request->url,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'status' => 1,
            ]);

            Session::put('success_message', 'Category Added Successfully');
            return redirect('admin/categories');

        }

        $all_section = Section::all();

        return view('admin.categories.add_edit_category', compact('title', 'all_section'));
    }

    /**
     * Append Parent CAtegory
     */
    public function appendCategoryLevel(Request $request){
        if($request->ajax()){

            $data = $request->all();

            $categories = Category::with('subCategories')->where(['section_id' => $data['section_id'], 'parent_id' => 0, 'status'=>1])->get();

            $categories = json_decode(json_encode($categories));
            // echo '<pre/>'; print_r($categories); die;

            return view('admin.categories.append_category_level', compact('categories'));

        }
    }
}
