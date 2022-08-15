<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Get All User
     */
    public function users(){
        Session::put('page', 'users');
        $users = User::get();
        return view('admin.users.users', compact('users'));
    }

    /**
     * Update User Status
     */
    public function updateUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            User::where('id', $data['user_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'user_id' => $data['user_id']
            ]);
        }
    }

    /**
     * View Users Charts Report
     */
    public function viewUsersCharts(){
        $current_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $before_1_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $before_2_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        $before_3_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3))->count();
        $userCount = [$current_month_users, $before_1_month_users, $before_2_month_users, $before_3_month_users];
        return view('admin.users.view_users_charts', compact('userCount'));
    }
}
