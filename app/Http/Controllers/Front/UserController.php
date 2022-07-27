<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
