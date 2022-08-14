<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RatingsController extends Controller
{
    /**
     * Add Review & Rating
     */
    public function addRating(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if(!Auth::check()){
                $message = "Login to rate this product";
                Session::put('error_message', $message);
                return redirect()->back();
            }

        }
    }
}
