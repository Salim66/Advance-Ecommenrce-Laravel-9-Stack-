<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get User Cart Items
     */
    public static function userCartItem(){
        if(Auth::check()){
            $user_cart_item = Cart::with(['product'=>function($query){
                $query->select('id', 'product_name', 'product_code', 'product_color', 'main_image');
            }])->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }else {
            $user_cart_item = Cart::with(['product'=>function($query){
                $query->select('id', 'product_name', 'product_code', 'product_color', 'main_image');
            }])->where('session_id', Session::get('session_id'))->orderBy('id', 'DESC')->get();
        }
        return $user_cart_item;
    }

    /**
     * Get Product Attribute Price
     */
    public static function getProductAttrPrice($product_id, $size){
        $attrPrice = ProductAttribute::select('price')->where(['product_id'=>$product_id, 'size'=>$size])->first();
        return $attrPrice->price;
    }

}
