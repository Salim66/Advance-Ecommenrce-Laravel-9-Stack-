<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Facades\Session;

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
        }else {
            $title = "Edit Product";
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
