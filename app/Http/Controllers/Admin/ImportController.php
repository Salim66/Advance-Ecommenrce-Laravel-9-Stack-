<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ImportController extends Controller
{
    /**
     * Update COD Pincode
     */
    public function updateCodPincode(Request $request){
        Session::put('page', 'import_cod_pincode');
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

            $file = public_path('imports/pincodes/'.$filename);
            $pincodes = $this->csvToArray($file);
            // return $pincodes; die;
            $latestPincodes = [];
            foreach($pincodes as $key => $pincode){
                $latestPincodes[$key]['pincode'] = $pincode['pincode'];
                $latestPincodes[$key]['created_at'] = date('Y-m-d H:i:s');
                $latestPincodes[$key]['updated_at'] = date('Y-m-d H:i:s');
            }

            DB::table('cod_pincodes')->delete();
            DB::update('Alter Table cod_pincodes AUTO_INCREMENT=1;');
            DB::table('cod_pincodes')->insert($latestPincodes);

            $message = "COD Pincode has been replaced successfully!";
            Session::flash('success_message', $message);
            return redirect()->back();

        }
        return view('admin.pincodes.update_cod_pincode');

    }


    /**
     * Update Prepaid Pincode
     */
    public function updatePrepaidPincode(Request $request){
        Session::put('page', 'import_prepaid_pincode');
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

            $file = public_path('imports/pincodes/'.$filename);
            $pincodes = $this->csvToArray($file);
            // return $pincodes; die;
            $latestPincodes = [];
            foreach($pincodes as $key => $pincode){
                $latestPincodes[$key]['pincode'] = $pincode['pincode'];
                $latestPincodes[$key]['created_at'] = date('Y-m-d H:i:s');
                $latestPincodes[$key]['updated_at'] = date('Y-m-d H:i:s');
            }

            DB::table('prepaid_pincode')->delete();
            DB::update('Alter Table prepaid_pincode AUTO_INCREMENT=1;');
            DB::table('prepaid_pincode')->insert($latestPincodes);

            $message = "Prepaid Pincode has been replaced successfully!";
            Session::flash('success_message', $message);
            return redirect()->back();

        }
        return view('admin.pincodes.update_prepaid_pincode');

    }

    /**
     * CSV to Array Coverter
     */
    public function csvToArray($filename = '', $delimiter = ','){
        if (!file_exists($filename) || !is_readable($filename))
            return false;
            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false){
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false){
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
                }
            fclose($handle);
            }
        return $data;
    }
}
