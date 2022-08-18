<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ImportController extends Controller
{
    /**
     * Update COD Pincode
     */
    public function updateCodPincode(Request $request){
        Session::put('page', 'import_pincode');
        if($request->isMethod('post')){
            $data = $request->all();

            // Upload Pincode CSV to pincode folder
            if($request->hasFile('file')){
                if($request->file('file')->isValid()){
                    $file = $request->file('file');
                    $destination = public_path('imports/pincodes');
                    $ext = $file->getClientOriginalExtension();
                    $filename = 'pincode-'.rand().".".$ext;
                    $file->move($destination, $filename);
                }
            }

        }
        return view('admin.pincodes.update_cod_pincode');

    }
}
