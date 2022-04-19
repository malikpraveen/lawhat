<?php

namespace App\Http\Controllers\Admin;


use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\NumberPlate;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller {

    protected $guard = "admin";
    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        // $this->middleware('admin');

        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
//                 dd($this->middleware('auth'));
    }

    public function getLogout(request $request) {
        Auth::guard('admin')->logout();
        Session::forget('admin_logged_in');

        return redirect('admin/login');
    }

    

    public function dashboard(Request $request) {
        if (!Auth::guard('admin')->check()) {
          
            return redirect()->intended('admin/login');
        } else {
             $user_count = 0;
            $users = User::where('status', 'active')->orderBy('id', 'DESC')->get();
             if ($users) {
            $user_count = count($users);
             $users = User::orderBy('id', 'DESC')->limit(5)->get();
             $total_plates = NumberPlate::where('status','enable')->orderBy('id','desc')->get();
             $data['users'] = $users;
            } else {
             $data['users'] = [];
            }
            $data['total_user'] = $user_count;
            $data['total_plates'] = count($total_plates);
             return view('admin.dashboard')->with($data);
        }

    }

    public function edit_profile(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            if(Session::get('admin_logged_in')['type']=='0'){
                $data['edit_admin'] = Admin::where('id',Auth::guard('admin')->id())->where('status','active')->first();
             return view('admin.edit_profile')->with($data);
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
            'type' => '0',
            'otp' => mt_rand(10000,999999),

        ];
  
   $update = Admin::find($id)->update($data);
   if($update){
       return redirect('admin/edit_profile')->with('success', ' update successfully.');
   }
   else {
       return redirect()->back()->with('error', 'Some error occurred while update ');
   }

   }
}

    

}
