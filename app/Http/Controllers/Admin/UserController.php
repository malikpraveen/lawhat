<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class UserController extends Controller
{
    public function change_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
        $update = User::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }


    }

    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $users = User::orderBy('id', 'DESC')
            ->get();
             $data['users'] = $users;
             return view('admin.users.user_list')->with($data);
        }
    }



    public function filter_list(Request $request) {
        $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
        if ($request->input('start_date') && $request->input('end_date')) {
            $users = User::where('status', '<>', 99)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $users = User::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
        }
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['users'] = $users;
        return view('admin.users.user_list')->with($data);
    }

    public function show(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
            $id = base64_decode($id);
             $user = User::with('number_plate')->where('id',$id)->first();    
            $data['user'] = $user;
        
            if ($data) {                
                
                return view('admin.users.user_detail')->with($data);
            } else {
                return redirect('admin/dashboard')->with('error', 'User not found');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }


  
}
