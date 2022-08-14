<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    /**
     * Curriencies
     */
    public function currencies(){
        Session::put('page', 'currencies');
        $currencies = Currency::all();
        return view('admin.currencies.currencies', compact('currencies'));
    }

    /**
     * Update currency status
     */
    public function updateCurrencyStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Currency::where('id', $data['currency_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'currency_id' => $data['currency_id']
            ]);
        }
    }
}
