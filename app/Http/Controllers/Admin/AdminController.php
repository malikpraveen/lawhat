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
    

    

    

}
