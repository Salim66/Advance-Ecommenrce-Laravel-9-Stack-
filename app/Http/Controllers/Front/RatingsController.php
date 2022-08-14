<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Rating;
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

            if(!isset($data['rating'])){
                $message = "Add atleast one star rating for this product";
                Session::put('error_message', $message);
                return redirect()->back();
            }

            $ratingCount = Rating::where('user_id', Auth::user()->id)->where('product_id', $data['product_id'])->count();
            if($ratingCount > 0){
                $message = "Your rating already exists for this product";
                Session::put('error_message', $message);
                return redirect()->back();
            }else {

                Rating::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $data['product_id'],
                    'rating' => $data['rating'],
                    'review' => $data['review'],
                ]);

                $message = "Thanks for rating this product! It will be shown once approved.";
                Session::put('success_message', $message);
                return redirect()->back();
            }

        }
    }
}
