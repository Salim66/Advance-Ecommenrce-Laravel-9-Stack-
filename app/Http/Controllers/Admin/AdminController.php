<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Http\Controllers\Controller;
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

    /**
     * Update Admin Current Password
     */
    public function updateCurrentPassword(Request $request){
        // Check Requrest Method is POST or not
        if($request->isMethod('POST')){
            $data = $request->all();
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                // Check new password and confirm password is match
                if($data['new_pwd'] == $data['confirm_pwd']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Your Current password is updated successfully :)');
                }else {
                    Session::flash('error_message', 'New password and Confirm password is not match!');
                }
            }else {
                Session::flash('error_message', 'Current password is not match!');
            }

            return redirect()->back();
        }
    }

    /**
     * Update Admin Details
     */
    public function updateAdminDetails(Request $request){
        if($request->isMethod('POST')){
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric'
            ];
            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha'  => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric'  => 'Valid mobile is required'
            ];
            $this->validate($request, $rules, $customMessage);

            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'name' => $data['admin_name'],
                'mobile' => $data['admin_mobile']
            ]);

            Session::flash('success_message', 'Admin details updated successfully :)');
            return redirect()->back();
        }
        return view('admin.admin_update_details');
    }
}
