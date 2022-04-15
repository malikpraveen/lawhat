<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;

use DB;

class SubAdminController extends Controller
{
 
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            if(Session::get('admin_logged_in')['type']=='0'){
            $sub_admins = Admin::where('type','1')->orderBy('id', 'DESC')
            ->get();
             $data['sub_admin'] = $sub_admins;
             return view('admin.sub_admin.sub_admin_list')->with($data);
        }
    }
    }



    public function change_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Admin::find($id)->where('type','1')->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }


    }


    public function submit(Request $request){
        if(Session::get('admin_logged_in')['type']=='0'){

          $data=[
             "name" => $request->input('name'),
             "email" => $request->input('email'),
             'password' => Hash::make($request->password),
             'type' => '1',
             'otp' => mt_rand(10000,999999),
 
         ];
          $add = Admin::create($data);
        
         if ($add) {
            return redirect()->back()->with('success','sub Admin added successfully');
         } else {
             return redirect()->back()->with('error', 'Some error occurred while adding sub admin');
         }
        }
         
     }


     public function edit_subadmin(Request $request, $id=null){
        if(Session::get('admin_logged_in')['type']=='0'){
        $id = base64_decode($id);
        //return $id;
        $data['edit_subadmin'] = Admin::where('id',$id)->where('type','1')->first();
        if($data){
            return view('admin.sub_admin.edit_subadmin')->with($data);

        }else{
            return redirect()->back()->with('error','details not found');
        }
    }
        
    }


    public function edit_update(Request $request, $id=null){
        if(Session::get('admin_logged_in')['type']=='0'){
        $id = base64_decode($id);
        $data=[
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            'password' => Hash::make($request->password),
            'type' => '1',
            'otp' => mt_rand(10000,999999),

        ];
  
   $update = Admin::find($id)->update($data);
   if($update){
       return redirect('admin/sub-admin-management')->with('success', ' update successfully.');
   }
   else {
       return redirect()->back()->with('error', 'Some error occurred while update ');
   }

   }
}

  
}
