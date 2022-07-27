<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * @access public
     * @route /login-register
     * @method GET
     */
    public function loginRegister(){
        return view('front.users.login_register');
    }

    /**
     * @access public
     * @route /register
     * @method POST
     */
    public function registerUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // Check user is already login
            $userCount = User::where('email', $data['email'])->count();
            if($userCount > 0){
                $message = "User already exists!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }else {
                // Register the user
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    return redirect('cart');
                }
            }
        }
    }

    /**
     * @access private
     * @route /logout
     * @method GET
     */
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
