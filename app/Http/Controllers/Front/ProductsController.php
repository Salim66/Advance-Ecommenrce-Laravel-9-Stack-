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
            $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1)->simplePaginate(1);
            // return $catDetails; die;
            return view('front.products.listing', compact('catDetails', 'catProducts'));
        }else {
            abort(404);
        }
    }
}
