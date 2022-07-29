<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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

            // Session forget
            Session::forget('success_message');
            Session::forget('error_message');

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

                // Send user to email varification link to active account
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])
                ];
                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                    $message->to($email)->subject('Confirm your E-Commerce Website');
                });

                $message = "Please confirm your email to active your account!";
                Session::put('success_message', $message);
                return redirect()->back();

                // if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){

                //     // User is logged in then update the previous session id cart product
                //     if(!empty(Session::get('session_id'))){
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                //     }

                //     // Send Regiter SMS
                //     $message = "Dear Customer, you have been successfully register with E-Com website. Login to your account to access order and available offers.";
                //     $mobile = $data['mobile'];
                //     Sms::sendSMS($message, $mobile);

                //     // Send Mail When your Registation
                //     $email = $data['email'];
                //     $messageData = ['name' => $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email']];
                //     Mail::send('emails.register', $messageData, function($message) use($email){
                //         $message->to($email)->subject('Welcome to E-Commerce Website');
                //     });

                //     return redirect('cart');
                // }
            }
        }
    }

    /**
     * @access private
     * @routes /confirm/{email}
     * @method any
     */
    public function confirmAccount($email){
        $email = base64_decode($email);

        Session::forget('success_message');
        Session::forget('error_message');

        // Check user email exists
        $userCount = User::where('email', $email)->count();
        if($userCount > 0){
            // User email is already activated or not
            $userDetails = User::where('email', $email)->first();
            if($userDetails->status == 1){
                $message = "Your email account is already activated. Please login.";
                Session::put('error_message', $message);
                return redirect('login-register');
            }else {

                // Update user status to 1 to activated account
                User::where('email', $email)->update(['status' => 1]);

                // Send Regiter SMS
                // $message = "Dear Customer, you have been successfully register with E-Com website. Login to your account to access order and available offers.";
                // $mobile = $userDetails['mobile'];
                // Sms::sendSMS($message, $mobile);

                // Send Mail When your Registation
                $messageData = ['name' => $userDetails['name'], 'mobile' => $userDetails['mobile'], 'email' => $userDetails['email']];
                Mail::send('emails.register', $messageData, function($message) use($email){
                    $message->to($email)->subject('Welcome to E-Commerce Website');
                });

                // Redirect to login/register page with success message
                $message = "Your email account is activated. Please login your account.";
                Session::put('success_message', $message);
                return redirect('login-register');

            }
        }else {
            abort(404);
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

            // Session destroy
            Session::forget('success_message');
            Session::forget('error_message');

            // check user email and password is match or not
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){

                // Check email is activeted or not
                $userStatus = User::where('email', $data['email'])->first();
                if($userStatus->status == 0){
                    $message = "Your account is not activated yet! please confirm your email to ativate";
                    Session::put('error_message', $message);
                    return redirect()->back();
                }

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
