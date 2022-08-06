<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function images(){
        return $this->hasMany(ProductImages::class);
    }

    public static function productFilters(){
        $productFilters['fabricArray'] = ["Cotton", "Polyester", "Wool"];
        $productFilters['sleeveArray'] = ["Full Sleeve", "Half Sleeve", "Short Sleeve", "Sleeveless"];
        $productFilters['patternArray'] = ["Checked", "Plain", "Printed", "Self", "Solid"];
        $productFilters['fitArray'] = ["Regular", "Slim"];
        $productFilters['occasionArray'] = ["Casual", "Formal"];
        return $productFilters;
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();
        $catDetails = Category::select('category_discount')->where('id', $proDetails->category_id)->first();
        if($proDetails->product_discount > 0){
            // If product discount is added from admin panel
            $discounted_price = $proDetails->product_price - ($proDetails->product_price * $proDetails->product_discount/100);
        }else if($catDetails->category_discount > 0){
            // If product discount is not added from admin panel and category discount is added admin panel
            $discounted_price = $proDetails->product_price - ($proDetails->product_price * $catDetails->category_discount/100);
        }else {
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountedAttrPrice($product_id, $size){
        $proAttrPrice = ProductAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first();
        $proDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first();
        $catDetails = Category::select('category_discount')->where('id', $proDetails->category_id)->first();

        if($proDetails->product_discount > 0){
            // If product discount is added from admin panel
            $final_price = $proAttrPrice->price - ($proAttrPrice->price * $proDetails->product_discount/100);
            $discount = $proAttrPrice->price - $final_price;
        }else if($catDetails->category_discount > 0){
            // If product discount is not added from admin panel and category discount is added admin panel
            $final_price = $proAttrPrice->price - ($proAttrPrice->price * $catDetails->category_discount/100);
            $discount = $proAttrPrice->price - $final_price;
        }else {
            $final_price = $proAttrPrice->price;
            $discount = 0;
        }
        return ['product_price'=>$proAttrPrice->price, 'final_price'=>$final_price, 'discount'=>$discount];

    }

    public static function getProductImage($product_id){
        $getProductImage = Product::select('main_image')->where('id', $product_id)->first();
        return $getProductImage;
    }

}
