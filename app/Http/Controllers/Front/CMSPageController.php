<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CMSPageController extends Controller
{
    /**
     * CMSPage 
     */
    public function cmsPage(){
        $currentRoute = url()->current();
        $currentRoute = str_replace('http://localhost:8000/','', $currentRoute);
        $cmsRoute = CmsPage::where('status', 1)->get()->pluck('url')->toArray();
        if(in_array($currentRoute, $cmsRoute)){
            $cmsPageDetails = CmsPage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.cms_page', compact('cmsPageDetails'));
        }
    }

    /**
     * Contact Us page
     */
    public function contact(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
            ];

            $customMessage = [
                'name.required' => 'Name field are required',
                'email.required' => 'Email field are required',
                'email.email' => 'Vaild email are required',
                'subject.required' => 'Subject field are required',
                'message.required' => 'Message field are required',
            ];

            $validator = Validator::make($data,$rules,$customMessage);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            // Send Mail for Admin
            $email = "salim111222@yopmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'text' => $data['message'],
            ];

            Mail::send('emails.enquery',$messageData,function($message) use($email){
                $message->to($email)->subject('Confirm Your ECommerce Account.');
            });
        }

        $message = "Your enquiry successfully send.";
        Session::flash('success_message', $message);
        return view('front.pages.contact');
    }
}
