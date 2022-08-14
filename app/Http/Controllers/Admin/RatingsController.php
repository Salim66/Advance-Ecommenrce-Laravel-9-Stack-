<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Support\Facades\Session;

class RatingsController extends Controller
{
    /**
     * Ratings
     */
    public function ratings(){
        Session::put('page', 'ratings');
        $ratings = Rating::with(['user','product'])->get();
        return view('admin.ratings.ratings', compact('ratings'));
    }

    /**
     * Update ratings status
     */
    public function updateRatingStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Rating::where('id', $data['rating_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'rating_id' => $data['rating_id']
            ]);
        }
    }
}
