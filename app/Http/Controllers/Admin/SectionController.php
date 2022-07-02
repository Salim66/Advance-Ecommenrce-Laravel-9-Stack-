<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * All Section List
     */
    public function sections(){
        $all_data = Section::get();
        return view('admin.sections.sections', compact('all_data'));
    }
}
