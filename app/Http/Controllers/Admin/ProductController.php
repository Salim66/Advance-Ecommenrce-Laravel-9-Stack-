<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Facades\Session;
use Image;

class ProductController extends Controller
{
    /**
     * All Product List
     */
    public function products(){
        Session::put('page', 'products');
        $all_data = Product::with(['category' => function($queey){
            $queey->select('id', 'category_name');
        }, 'section' => function($query){
            $query->select('id', 'name');
        }])->get();
        return view('admin.products.products', compact('all_data'));
    }

    /**
     * Update Product Status
     */
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'product_id' => $data['product_id']
            ]);
        }
    }

    /**
     * Delete Product With Image
     */
    public function deleteProduct($id){
        $product_data = Product::findOrFail($id);
        if(file_exists('images/product_images/'.$product_data->product_image) && !empty($product_data->product_image)){
            unlink('images/product_images/'.$product_data->product_image);
        }

        $product_data->delete();

        Session::put('success_message', 'Product Deleted Successfully ):');
        return redirect()->back();
    }

    /**
     * Add Edit Product
     */
    public function addEditCategory(Request $request, $id=null){
        // Check id has or not
        if($id==""){
            $title = "Add Product";
            $product = new Product;
        }else {
            $title = "Edit Product";
        }

        if($request->isMethod('post')){

            $data = $request->all();

            // echo "<pre>"; print_r($data); die;

            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'category_id' => 'required',
            ];
            $customMessage = [
                'product_name.required' => 'Name is required',
                'product_name.alpha'  => 'Valid name is required',
                'product_code.required'  => 'Product code is required',
                'product_code.alpha'  => 'Valid product code is required',
                'product_price.required'  => 'Product price is required',
                'product_price.alpha'  => 'Valid product price is required',
                'category_id.required' => 'Category id is required',
            ];
            $this->validate($request, $rules, $customMessage);


            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }

            $is_featured = '';
            if(empty($data['is_featured'])){
                $is_featured = "No";
            }else {
                $is_featured = "Yes";
            }

            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }

            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }

            if(empty($data['meta_keyword'])){
                $data['meta_keyword'] = "";
            }

            if(empty($data['product_color'])){
                $data['product_color'] = "";
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(empty($data['wash_care'])){
                $data['wash_care'] = 0;
            }

            if(empty($data['fabric'])){
                $data['fabric'] = "";
            }

            if(empty($data['pattern'])){
                $data['pattern'] = "";
            }

            if(empty($data['sleeve'])){
                $data['sleeve'] = "";
            }

            if(empty($data['fit'])){
                $data['fit'] = "";
            }

            if(empty($data['occasion'])){
                $data['occasion'] = "";
            }

            if(empty($data['product_video'])){
                $data['product_video'] = "";
            }

            if(empty($data['main_image'])){
                $data['main_image'] = "";
            }

            // Upload Product Main Image
            if($request->hasFile('main_image')){
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    // Get orginal image name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = $image_name . '-'. rand(111,9999) . '.' . $extension;
                    // Set paths for small, medium and large images
                    $large_image_path = 'images/product_images/large/' . $imageName; // W:1040, H:1200
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    // Upload large image
                    Image::make($image_tmp)->save($large_image_path);
                    // Upload medium and small image after resize
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    // Save product main image in product table
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Ger orginal video name
                    $video_name = $video_tmp->getClientOriginalName();
                    // Get video extension
                    $extension = $video_tmp->getClientOriginalExtension();
                    // Generate new video name
                    $videoName = $video_name. '-' . rand() . '.' . $extension;
                    // set path for video 
                    $video_path = 'videos/product_videos/';
                    // upload video
                    $video_tmp->move($video_path, $videoName);
                    // Save video in product table
                    $product->product_video = $videoName;
                }
            }

            // Save product details in product table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->is_featured = $is_featured;
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keyword = $data['meta_keyword'];
            $product->product_video = $data['product_video'];
            $product->main_image = $data['main_image'];
            $product->status = 1;
            $product->save();

            Session::flash('success_message', 'Product added successfully :)');
            return redirect('admin/products');

        }

        // Filter Array
        $filterArray = ["Cotton", "Polyester", "Wool"];
        $sleeveArray = ["Full Sleeve", "Half Sleeve", "Short Sleeve", "Sleeveless"];
        $patternArray = ["Checked", "Plain", "Printed", "Self", "Solid"];
        $fitArray = ["Regular", "Slim"];
        $occasionArray = ["Casual", "Formal"];

        // Sections with category and subcategory
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.add_edit_product', compact('title', 'filterArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories'));
    }
}
