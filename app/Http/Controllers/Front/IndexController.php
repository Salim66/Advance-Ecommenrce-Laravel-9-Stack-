<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Home page
     */
    public function index() {
        // Featured Products
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status', 1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        // Latest products
        $newProducts = Product::where('status', 1)->orderBy('id','DESC')->limit(6)->get();
        // return $newProducts;
        $page_name = 'index';
        $meta_title = "E-commerce Website by ThereeSixtyDegree";
        $meta_description = "ThreeSixty Degree E-Commerce is big shop place, we are welcome to by easy to good quality products.";
        $meta_keyword = "Cloth for Man, Woman, Kids";
        return view('front.index', compact('page_name', 'featuredItemsChunk', 'featuredItemsCount', 'newProducts', 'meta_title', 'meta_description', 'meta_keyword'));
    }
}
