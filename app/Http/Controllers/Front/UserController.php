<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
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

                    // User is logged in then update the previous session id cart product
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    return redirect('cart');
                }
            }
        }
    }

    /**
     * @access public
     * @route /check-email
     * @method POST
     */
    public function checkEmail(Request $request){
        $data = $request->all();

        // Check the user email already exists or not
        $user_email_count = User::where('email', $data['email'])->count();
        if($user_email_count > 0){
            return "false";
        }else {
            return "true";
        }
    }

    /**
     * @access public
     * @route /login
     * @method POST
     */
    public function loginUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // check user email and password is match or not
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){

                // User is logged in then update the previous session id cart product
                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }

                return redirect('cart');
            }else {
                $message = "Email and Password not match!";
                Session::flash('error_message', $message);
                return redirect()->back();
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
