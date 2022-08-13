<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\OtherSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;

class AdminController extends Controller
{
    /**
     * Dashboard load
     */
    public function dashboard(){
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    /**
     * Admin Settings
     */
    public function settings(){
        Session::put('page', 'settings');
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
            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])){
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
        Session::put('page', 'update-admin-details');
        if($request->isMethod('POST')){
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha'  => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric'  => 'Valid mobile is required',
                'admin_image.image'  => 'Valid image is required'
            ];
            $this->validate($request, $rules, $customMessage);

            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //Generate new image name
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else {
                    $imageName = "";
                }
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'name' => $data['admin_name'],
                'mobile' => $data['admin_mobile'],
                'image' => $imageName
            ]);

            Session::flash('success_message', 'Admin details updated successfully :)');
            return redirect()->back();
        }
        return view('admin.admin_update_details');
    }

    /**
     * Admins / Subadmins
     */
    public function adminsSubadmins(){
        Session::put('page', 'admins_subadmins');
        $admins = Admin::all();
        return view('admin.admins_subadmins.admins_subadmins', compact('admins'));
    }

    /**
     * Admin Subadmins Status Update
     */
    public function updateAdminsSubadminsstatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'admin_id' => $data['admin_id']
            ]);
        }
    }

    /**
     * Delete Admins / Subadmins
     */
    public function deleteAdminsSubadmins($id){
        $admin_data = Admin::findOrFail($id);

        $admin_data->delete();

        Session::put('success_message', 'Admins / Subadmins Deleted Successfully ):');
        return redirect()->back();
    }

    /**
     * Add Edit Admin / Subadmin
     */
    public function addEditAdminsSubadmins(Request $request, $id = null){

        if($id == ""){
            // Add Admin / Subadmin
            $title = "Add Admin / Subadmin";
            $admindata = new Admin;
            $message = "Admin/Subadmin added successfully";
        }else {
            // Edit Admin / Subadmin
            $title = "Edit Admin / Subadmin";
            $admindata = Admin::find($id);
            $message = "Admin/Subadmin updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;
            // Check email already exists
            if(empty($admindata->id)){
                $adminCount = Admin::where('email', $data['admin_email'])->count();
                if($adminCount > 0){
                    $message = "This email already exists";
                    Session::put('error_message', $message);
                    return redirect()->back();
                }
            }

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha'  => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric'  => 'Valid mobile is required',
                'admin_image.image'  => 'Valid image is required'
            ];
            $this->validate($request, $rules, $customMessage);

            $imageName = '';
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //Generate new image name
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else {
                    $imageName = "";
                }
            }else {
                $imageName = $data['current_admin_image'];
            }


            $admindata->name = $data['admin_name'];
            $admindata->mobile = $data['admin_mobile'];
            $admindata->image = $imageName;
            if(empty($admindata->id)){
                $admindata->email = $data['admin_email'];
            }
            $admindata->type = $data['admin_type'];
            $admindata->password = bcrypt($data['admin_password']);
            $admindata->save();

            Session::flash('success_message', 'Admin/Subadmin successfully :)');
            return redirect('/admin/admins-subadmins');

        }

        return view('admin.admins_subadmins.add_edit_admins_subadmins', compact('title', 'admindata'));
    }

    /**
     * Update Role
     */
    public function UpdateRoles(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);

            AdminRole::where('admin_id', $id)->delete();

            foreach($data as $key => $value){
                if(isset($value['view'])){
                    $view = $value['view'];
                }else {
                    $view = 0;
                }
                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else {
                    $edit = 0;
                }
                if(isset($value['full'])){
                    $full = $value['full'];
                }else {
                    $full = 0;
                }

                AdminRole::where('admin_id', $id)->insert([
                    "admin_id" => $id,
                    "module" => $key,
                    "view_access" => $view,
                    "edit_access" => $edit,
                    "full_access" => $full,
                ]);
            }
            $message = "Roles updated successfully :)";
            Session::put('success_message', $message);
            return redirect()->back();
        }

        $admindata = Admin::where('id', $id)->first();
        $adminRoles = AdminRole::where('admin_id', $id)->get();
        $title = "Update <strong>".$admindata->name."</strong> (".$admindata->type.") Roles/Permissions";
        return view('admin.admins_subadmins.update_roles', compact('title', 'admindata', 'adminRoles'));
    }

    /**
     * Update other settings
     */
    public function updateOtherSettings(Request $request){
        Session::put('page', 'update-other-settings');
        $otherSettings = OtherSetting::find(1);

        if($request->isMethod('post')){
            $data = $request->all();
            OtherSetting::where('id', 1)->update([
                'min_cart_value' => $data['min_cart_value'],
                'max_cart_value' => $data['max_cart_value']
            ]);

            $message = "Other Settings Update Successfully";
            Session::flash('success_message', $message);
            return redirect()->back();
        }

        return view('admin.other_settings', compact('otherSettings'));

    }
}
