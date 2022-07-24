<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductsController extends Controller
{
    /**
     * Listing/ Categories
     */
    public function listing(Request $request){
        Paginator::useBootstrap();
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];

            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount > 0){
                $catDetails = Category::categoryDetails($url);
                $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1);

                // If fabric filter is selected
                if(isset($data['fabric']) && !empty($data['fabric']) == 'fabric'){
                    $catProducts->whereIn('products.fabric', $data['fabric']);
                }

                // If fabric sleeve is selected
                if(isset($data['sleeve']) && !empty($data['sleeve']) == 'sleeve'){
                    $catProducts->whereIn('products.sleeve', $data['sleeve']);
                }

                // If pattern is selected
                if(isset($data['pattern']) && !empty($data['pattern']) == 'pattern'){
                    $catProducts->whereIn('products.pattern', $data['pattern']);
                }

                // If fit filter is selected
                if(isset($data['fit']) && !empty($data['fit']) == 'fit'){
                    $catProducts->whereIn('products.fit', $data['fit']);
                }

                // If occasion filter is selected
                if(isset($data['occasion']) && !empty($data['occasion']) == 'occasion'){
                    $catProducts->whereIn('products.occasion', $data['occasion']);
                }


                // If sort option is selected
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort'] == 'product_latest'){
                        $catProducts->orderBy('id', 'DESC');
                    }else if($data['sort'] == 'product_name_a_z'){
                        $catProducts->orderBy('product_name', 'ASC');
                    }else if($data['sort'] == 'product_name_z_a'){
                        $catProducts->orderBy('product_name', 'DESC');
                    }else if($data['sort'] == 'price_lowest'){
                        $catProducts->orderBy('product_price', 'ASC');
                    }else if($data['sort'] == 'price_highest'){
                        $catProducts->orderBy('product_price', 'DESC');
                    }
                }else {
                    $catProducts->orderBy('id', 'DESC');
                }

                $catProducts = $catProducts->paginate(2);

                // return $catDetails; die;
                return view('front.products.ajax_products_listing', compact('catDetails', 'catProducts', 'url'));
            }else {
                abort(404);
            }

        }else {
            $url = Route::getFacadeRoot()->current()->uri(); // get current path/uri
            // echo "<pre>"; print_r($url); die;
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount > 0){
                $catDetails = Category::categoryDetails($url);
                $catProducts = Product::with('brand')->where('category_id', $catDetails['catIds'])->where('status', 1);

                // Only for php page reload code
                // if(isset($_GET['sort']) && !empty($_GET['sort'])){
                //     if($_GET['sort'] == 'product_latest'){
                //         $catProducts->orderBy('id', 'DESC');
                //     }else if($_GET['sort'] == 'product_name_a_z'){
                //         $catProducts->orderBy('product_name', 'ASC');
                //     }else if($_GET['sort'] == 'product_name_z_a'){
                //         $catProducts->orderBy('product_name', 'DESC');
                //     }else if($_GET['sort'] == 'price_lowest'){
                //         $catProducts->orderBy('product_price', 'ASC');
                //     }else if($_GET['sort'] == 'price_highest'){
                //         $catProducts->orderBy('product_price', 'DESC');
                //     }
                // }else {
                //     $catProducts->orderBy('id', 'DESC');
                // }

                $catProducts = $catProducts->paginate(2);

                // Filter Array
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = 'listing';
                // return $catDetails; die;
                return view('front.products.listing', compact('catDetails', 'catProducts', 'url', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name'));
            }else {
                abort(404);
            }
        }


    }

    /**
     * @access public
     * @route /product/{code}/{id}
     * @method GET
     * Product Detials page
     */
    public function detail($code, $id){


        return view('front.products.detial');

    }
}
