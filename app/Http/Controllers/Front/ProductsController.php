<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Listing/ Categories
     */
    public function listing($url){
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if($categoryCount > 0){
            $catDetails = Category::categoryDetails($url);
            $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1);

            if(isset($_GET['sort']) && !empty($_GET['sort'])){
                if($_GET['sort'] == 'product_latest'){
                    $catProducts->orderBy('id', 'DESC');
                }else if($_GET['sort'] == 'product_name_a_z'){
                    $catProducts->orderBy('product_name', 'ASC');
                }else if($_GET['sort'] == 'product_name_z_a'){
                    $catProducts->orderBy('product_name', 'DESC');
                }else if($_GET['sort'] == 'price_lowest'){
                    $catProducts->orderBy('product_price', 'ASC');
                }else if($_GET['sort'] == 'price_highest'){
                    $catProducts->orderBy('product_price', 'DESC');
                }
            }else {
                $catProducts->orderBy('id', 'DESC');
            }

            $catProducts = $catProducts->simplePaginate(2);

            // return $catDetails; die;
            return view('front.products.listing', compact('catDetails', 'catProducts'));
        }else {
            abort(404);
        }
    }
}
