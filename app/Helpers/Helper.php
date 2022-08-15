<?php

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function totalCartItems(){
    if(Auth::check()){
        $toalCartItems = Cart::where('user_id', Auth::user()->id)->sum('quantity');
    }else {
        $session_id = Session::get('session_id');
        $toalCartItems = Cart::where('session_id', $session_id)->sum('quantity');
    }
    return $toalCartItems;
}

function totalWishlistItems(){
    if(Auth::check()){
        $toalWishlistItems = Wishlist::where('user_id', Auth::user()->id)->count();
    }
    return $toalWishlistItems;
}
