<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Dashboard load
     */
    public function dashboard(){
        return view('admin.admin_dashboard');
    }

    /**
     * Admin Settings
     */
    public function settings(){
        return view('admin.admin_settings');
    }

    /**
     * Admin loging page
     */
    public function login(Request $request){
        
        if($request->isMethod('post')){

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];

            $customMessage = [
                'email.required' => 'Email field is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password field is required'
            ];

            $this->validate($request, $rules, $customMessage);

            $data = $request->all();
            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){
                return redirect('/admin/dashboard');
            }else {
                Session::flash('error_message', 'Invalid Email Or Password!');
                return redirect()->back();
            }
        }

        return view('admin.admin_login');
    }

    /**
     * Admin Logout method
     */
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    /**
     * Check Admin Current Pssword
     */
    public function chkCurrentPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            echo 'true';
        }else {
            echo 'false';
        }
    }
}
