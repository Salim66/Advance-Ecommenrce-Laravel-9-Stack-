<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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

         // Set Admins/Subadmins Permission for Products
         $productModuleCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'products'])->count();
         if(Auth::guard('admin')->user()->type == 'super admin'){
            $productModule['view_access'] = 1;
            $productModule['edit_access'] = 1;
            $productModule['full_access'] = 1;
         }else if($productModuleCount == 0){
             $message = "This feature restricted for you!";
             Session::flash('error_message', $message);
             return redirect('admin/dashboard');
         }else {
             $productModule = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'products'])->first()->toArray();
         }

        return view('admin.products.products', compact('all_data', 'productModule'));
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
    public function addEditProduct(Request $request, $id=null){
        // Check id has or not
        if($id==""){
            $title = "Add Product";
            $product = new Product;
            $product_data = '';
            $message = "Product added successfully";
        }else {
            $title = "Edit Product";
            $product_data = Product::find($id);
            // return $product_data; die;
            $product = Product::find($id);
            $message = "Product updated successfully";
        }

        if($request->isMethod('post')){

            $data = $request->all();

            // echo "<pre>"; print_r($data); die;

            // product validation
            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'category_id' => 'required',
                'brand_id' => 'required',
            ];
            $customMessage = [
                'product_name.required' => 'Name is required',
                'product_name.alpha'  => 'Valid name is required',
                'product_code.required'  => 'Product code is required',
                'product_code.alpha'  => 'Valid product code is required',
                'product_price.required'  => 'Product price is required',
                'product_price.alpha'  => 'Valid product price is required',
                'category_id.required' => 'Category id is required',
                'barnd_id.required' => 'Brand id is required',
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

            $product_roduct_video = "";

            $product_main_image = "";

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
                    // echo $imageName; die;
                    $product_main_image = $imageName;
                }
            }else {
                $product_main_image = $product->main_image;
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
                    $product_roduct_video = $videoName;
                }
            }else {
                $product_roduct_video = $product->product_video;
            }

            // Save product details in product table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->group_code = $data['group_code'];
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
            $product->product_video = $product_roduct_video;
            $product->main_image = $product_main_image;
            $product->status = 1;
            $product->save();

            Session::flash('success_message', $message);
            return redirect('admin/products');

        }

        // Filter Array
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        // Sections with category and subcategory
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;

        // // brand
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.add_edit_product', compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'product_data', 'brands'));
    }


    /**
     * Delete Product Image
     */
    public function deleteProductImage($id){
        $product_data = Product::findOrFail($id);

        // small image deleted
        if(file_exists('images/product_images/small/'.$product_data->main_image) && !empty($product_data->main_image)){
            unlink('images/product_images/small/'.$product_data->main_image);
        }
        // medium image deleted
        if(file_exists('images/product_images/medium/'.$product_data->main_image) && !empty($product_data->main_image)){
            unlink('images/product_images/medium/'.$product_data->main_image);
        }
        // large image deleted
        if(file_exists('images/product_images/large/'.$product_data->main_image) && !empty($product_data->main_image)){
            unlink('images/product_images/large/'.$product_data->main_image);
        }

        Session::put('success_message', 'Product Image has been Deleted successfully');
        return redirect()->back();
    }


    /**
     * Delete Product Video
     */
    public function deleteProductVideo($id){
        $product_data = Product::findOrFail($id);

        // product video deleted
        if(file_exists('videos/product_videos/'.$product_data->product_video) && !empty($product_data->product_video)){
            unlink('videos/product_videos/'.$product_data->product_video);
        }

        Session::put('success_message', 'Product Video has been Deleted successfully');
        return redirect()->back();
    }


    ///////////////////// Product Attributes ////////////////////////

    /**
     * Add Attribute
     */
    public function addAttribute(Request $request, $id){


        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $value){
                if(!empty($value)){


                    // Check whethe the SKU already has or not
                    $attCountSku = ProductAttribute::where('sku', $value)->count();
                    if($attCountSku>0){
                        $message = "SkU already exists, Please add another SKU";
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    // Check whethe the Size already has or not
                    $attCountSize = ProductAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if($attCountSize>0){
                        $message = "Size already exists, Please add another size";
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();

                }
            }

            $message = "Product attribute has been added successfully";
            Session::flash('success_message', $message);
            return redirect()->back();

        }

        $product_data = Product::select(['id', 'product_name', 'product_code', 'product_color', 'main_image', 'product_price'])->with('attributes')->find($id);

        return view('admin.products.add_attribute', compact('product_data'));
    }

    /**
     * Edit Attribute
     */
    public function editAttribute(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(!empty($data)){

                foreach($data['attrId'] as $key => $value){

                    ProductAttribute::where('id',$value)->update([
                        'price' => $data['price'][$key],
                        'stock' => $data['stock'][$key],
                    ]);

                }

                $message = 'Product attribute has been updated successfully';
                Session::flash('success_message', $message);
                return redirect()->back();

            }
        }
    }


    /**
     * Update Attribute Status
     */
    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            ProductAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'attribute_id' => $data['attribute_id']
            ]);
        }
    }


    /**
     * Delete Attribute
     */
    public function deleteAttribute($id){
        $attribute_data = ProductAttribute::findOrFail($id);

        $attribute_data->delete();

        Session::put('success_message', 'Product Attribute Deleted Successfully ):');
        return redirect()->back();
    }


    //////////////// Add Images ////////////////

    /**
     * Add product images
     */
    public function addImages(Request $request, $id){

        if($request->isMethod('post')){
            if($request->hasFile('image')){
                $images = $request->file('image');
                foreach($images as $key => $image){
                    $product_image = new ProductImages;
                    $image_tmp = Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,999999) . time() . '.' . $extension;
                     // Set paths for small, medium and large images
                     $large_image_path = 'images/product_images/large/' . $imageName; // W:1040, H:1200
                     $medium_image_path = 'images/product_images/medium/' . $imageName;
                     $small_image_path = 'images/product_images/small/' . $imageName;
                     // Upload large image
                     Image::make($image_tmp)->save($large_image_path);
                     // Upload medium and small image after resize
                     Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                     Image::make($image_tmp)->resize(260,300)->save($small_image_path);

                     $product_image->product_id = $id;
                     $product_image->image = $imageName;
                     $product_image->save();
                }

                $message = 'Product Images has beed added successfully';
                Session::flash('success_message', $message);
                return redirect()->bacK();
            }
        }


        $product_data = Product::select(['id', 'product_name', 'product_code', 'product_color', 'main_image'])->with('images')->find($id);
        // return $product_data;
        $title = 'Add Images';
        return view('admin.products.add_images', compact('product_data', 'title'));

    }


    /**
     * Update Product Image Status
     */
    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            ProductImages::where('id', $data['image_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'image_id' => $data['image_id']
            ]);
        }
    }


    /**
     * Delete Product Images
     */
    public function deleteImage($id){

        $product_data = ProductImages::findOrFail($id);
        // small image delete
        if(file_exists('images/product_images/small/'.$product_data->image) && !empty($product_data->image)){
            unlink('images/product_images/small/'.$product_data->image);
        }
        // medium image delete
        if(file_exists('images/product_images/medium/'.$product_data->image) && !empty($product_data->image)){
            unlink('images/product_images/medium/'.$product_data->image);
        }
        // large image delete
        if(file_exists('images/product_images/large/'.$product_data->image) && !empty($product_data->image)){
            unlink('images/product_images/large/'.$product_data->image);
        }

        $product_data->delete();

        Session::put('success_message', 'Product Image Deleted Successfully ):');
        return redirect()->back();
    }
}
