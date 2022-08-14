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

    /**
     * Add Edit Currency
     */
    public function addEditCurrency(Request $request, $id=null){
        if($id==""){
            // Add Currency
            $title = "Add Currency";
            $currency = new Currency;
            $message = "Add Currency Successfully";
        }else {
            //Edit Currency
            $title = "Edit Currency";
            $currency = Currency::find($id);
            $message = "Update Currency Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $data['exchange_rate'];
            $currency->save();

            Session::put('success_message', $message);
            return redirect('/admin/currencies');
        }

        return view('admin.currencies.add_edit_currency', compact('title', 'currency'));

    }

    /**
     * Currency Delete
     */
    public function deleteCurrency($id){
        $currency_data = Currency::findOrFail($id);

        $currency_data->delete();

        Session::put('success_message', 'Currency Deleted Successfully ):');
        return redirect()->back();
    }
}
