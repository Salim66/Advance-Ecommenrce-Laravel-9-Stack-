<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingCargesController extends Controller
{
    /**
     * View Shipping Charges
     */
    public function viewShippingCharges(){
        Session::put('page', 'shopping-charges');
        $shipping_charges = ShippingCharge::get();
        return view('admin.shipping.view_shipping_charges', compact('shipping_charges'));
    }

    /**
     * Edit Shipping Charges
     */
    public function editShippingCharges(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();
            $shippingDetails = ShippingCharge::where('id', $id)->update(['shipping_charges' => $data['shipping_charges']]);
            
            $message = "Shipping Charges Updated Successfully!";
            Session::flash('success_message', $message);
            return redirect('/admin/shipping-charges');
        }

        $shippingDetails = ShippingCharge::where('id', $id)->first();
        return view('admin.shipping.edit_shipping_charges', compact('shippingDetails'));
    }


    /**
     * Update Shipping Charges Status
     */
    public function updateShippingStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            ShippingCharge::where('id', $data['shipping_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'shipping_id' => $data['shipping_id']
            ]);
        }
    }
}
