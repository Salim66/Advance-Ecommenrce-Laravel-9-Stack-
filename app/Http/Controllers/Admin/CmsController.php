<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CmsController extends Controller
{
    /**
     * CMS Pages
     */
    public function cmsPages(){
        Session::put('page','cmspage');
        $cmsPages = CmsPage::all();
        return view('admin.pages.cms_pages', compact('cmsPages'));
    }

    /**
     * Update cms page status
     */
    public function updateCmsPagetatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'page_id' => $data['page_id']
            ]);
        }
    }

    /**
     * Add Edit CMS page
     */
    public function addEditCmsPage(Request $request, $id=null){
        if($id==""){
            $title = "Add CMS Page";
            $cmspage = new CmsPage;
            $message = "Add CMS Page Successfully";
        }else {
            $title = "Edit CMS Page";
            $cmspage = CmsPage::find($id);
            $message = "Update CMS Page Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'title' => 'required|regex:/^[\pL\s\-]+$/u',
                'url' => 'required',
                'description' => 'required',
            ];
            $customMessage = [
                'title.required' => 'Title is required',
                'title.alpha'  => 'Valid title is required',
                'url.required' => 'URL is required',
                'description.required'  => 'Description is required'
            ];
            $this->validate($request, $rules, $customMessage);

            $cmspage->title = $request->title;
            $cmspage->url = $request->url;
            $cmspage->description = $request->description;
            $cmspage->meta_title = $request->meta_title;
            $cmspage->meta_description = $request->meta_description;
            $cmspage->meta_keyword = $request->meta_keyword;
            $cmspage->save();

            Session::flash('success_message', $message);
            return redirect('/admin/cms-pages');

        }

        return view('admin.pages.add_edit_cms_page', compact('title', 'cmspage'));
    }

     /**
     * Delete CMS Page
     */
    public function deleteCmsPage($id){
        $cms_page = CmsPage::findOrFail($id);

        $cms_page->delete();

        Session::put('success_message', 'CMS Page Deleted Successfully ):');
        return redirect()->back();
    }
}
