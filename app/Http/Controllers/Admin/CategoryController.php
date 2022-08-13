<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use Illuminate\Support\Facades\Auth;
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

        // Set Admins/Subadmins Permission for Category
        $categoryModuleCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'categories'])->count();
        if(Auth::guard('admin')->user()->type == 'super admin'){
            $categoryModule['view_access'] = 1;
            $categoryModule['edit_access'] = 1;
            $categoryModule['full_access'] = 1;
        }else if($categoryModuleCount == 0){
            $message = "This feature restricted for you!";
            Session::flash('error_message', $message);
            return redirect('admin/dashboard');
        }else {
            $categoryModule = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'categories'])->first()->toArray();
        }

        return view('admin.categories.categories', compact('all_data', 'categoryModule'));
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
            $category = new Category;
            $category_data = [];
            $categories = [];
            $message = 'Category Added Successfully';
        }else {
            $title = 'Edit Category';
            //Edit Category Functionality
            $category_data = Category::findOrFail($id);
            $categories = Category::with('subCategories')->where(['parent_id'=>0, 'section_id'=>$category_data->section_id])->get();
            // return $categories;
            $category = Category::find($id);
            $message = 'Category Updated Successfully';
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

                    $category->category_image = $imageName;
                }
            }


            $category->parent_id = $request->parent_id;
            $category->section_id = $request->section_id;
            $category->category_name = $request->category_name;
            $category->category_discount = $request->category_discount;
            $category->description = $request->description;
            $category->url = $request->url;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keyword = $request->meta_keyword;
            $category->status = 1;
            $category->save();


            Session::put('success_message', $message);
            return redirect('admin/categories');

        }

        $all_section = Section::all();

        return view('admin.categories.add_edit_category', compact('title', 'all_section', 'category_data', 'categories'));
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

    /**
     * Delete Category Image
     */
    public function deleteCategoryImage($id){
        $category_data = Category::findOrFail($id);
        if(file_exists('images/category_images/'.$category_data->category_image) && !empty($category_data->category_image)){
            unlink('images/category_images/'.$category_data->category_image);
        }

        Session::put('success_message', 'Category Image Deleted');
        return redirect()->back();
    }

    /**
     * Delete Category With Image
     */
    public function deleteCategory($id){
        $category_data = Category::findOrFail($id);
        if(file_exists('images/category_images/'.$category_data->category_image) && !empty($category_data->category_image)){
            unlink('images/category_images/'.$category_data->category_image);
        }

        $category_data->delete();

        Session::put('success_message', 'Category Deleted Successfully ):');
        return redirect()->back();
    }
}
