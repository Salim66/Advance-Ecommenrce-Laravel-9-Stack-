<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    /**
     * All Section List
     */
    public function sections(){
        Session::put('page', 'sections');
        $all_data = Section::get();
        return view('admin.sections.sections', compact('all_data'));
    }

    /**
     * Update Section Status
     */
    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Section::where('id', $data['section_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'section_id' => $data['section_id']
            ]);
        }
    }
}
