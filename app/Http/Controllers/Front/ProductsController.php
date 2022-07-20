<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Listing/ Categories
     */
    public function listing($url){
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if($categoryCount > 0){
            $categoryDetails = Category::categoryDetails($url);
            return $categoryDetails;
        }else {
            abort(404);
        }
    }
}
