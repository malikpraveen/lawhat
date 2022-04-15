<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\otp;
use Auth;
use DB;
use Validator;
use Response;
use URL;
use Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $guard = "admin";
    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {

        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
    }

    public function login(Request $request) {
     if (\Auth::guard('admin')->check()) {
         return redirect()->intended('admin/dashboard');
       }    
     $data['title'] = 'Admin Login';
      return view('admin.login')->with($data);
     }

   public function forgot() {
     return view('admin.forgot');
     } 
        
     

    public function forgotten(Request $request) {
        
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
                ], [
            'email.required' => 'Please enter email address.',
            'email.email' => 'Please enter valid email address.',
       ]);

        $validator->after(function ($validator) use (&$Admin, $request) {
            $Admin = Admin::where('email', $request->email)->where('type', '0')->orwhere('type','1')->first();

          if (empty($Admin)) {
                $validator->errors()->add('email', 'Your Account does not exist');
           } 
        //    else {
        //   if ($Admin->status == 'inactive') {
        //     $validator->errors()->add('email', 'Your Account is not active');
        //    }
        //   if ($Admin->status == 'trashed') {
        //     $validator->errors()->add('email', 'Your Account is rejected by admin');
        //    }
        //  }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $Admin = Admin::where('email', $request->email)->where('type', '0')->orWhere('type','1')->first();
            $otpAdmin['user_id'] = $Admin['id'];
            $otpAdmin['otp'] =  rand(100000, 999999);

            $otp = otp::create($otpAdmin);
    
            return redirect()->route('otp', ['id' => base64_encode($otpAdmin['user_id'])]);
         
            
        }
        
    }

    public function showotp(Request $request) {
        
        $id = base64_decode($request->id);
        $adminOtp = Admin::where('id', $id)->first();
        $otp = otp::where(['user_id' => $adminOtp->id])->latest()->first();
        $adminOtp['otp'] = $otp->otp;
        //return $adminOtp;
       
        return view('admin.otp',$adminOtp);
    }

    public function checkOTP(Request $request){
        //return $a = $request->all();
        $validator = \Validator::make($request->all(), [
         'otp' => 'required',
             ], [
         'otp.required' => 'Please enter otp',
       ]);
 
       $validator->after(function ($validator) use ($request) {
         $checkOTP = otp::where([
                     'user_id' => $request['admin_id'],
                         // 'otp' => $request['otp'],
                 ])->latest()->first();
         if ($checkOTP['otp'] != $request->otp) {
             
             $validator->errors()->add('otp', 'otp is not correct please provide correct otp');
         }
         // dd('a');
     });
 
     if ($validator->fails()) {
         // dd($validator->errors());
         return redirect()->back()->withErrors($validator)->withInput();
     } else {
 
         $checkAdmin = Admin::find($request['admin_id']);
         return redirect()->route('resetPassword', ['id' => base64_encode($checkAdmin['id'])]);
     }
 
     }

     public function resetPassword(Request $request) {

        
        $id = base64_decode($request->id);
        $AdminPswd = Admin::where('id', $id)->first();
       
        return view('admin.reset', $AdminPswd);
    }

    public function ConfirmPassword(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'password' => 'required|min:8|max:15',
            'confirm_password' => 'required',
                ], [
            'password.required' => 'please enter new password',
            'password.min' => 'password must be between 8 to 15 characters',
            'password.max' => 'password must be between 8 to 15 characters',
            'confirm_password.required' => 'please enter confirm password',
       ]);

       $validator->after(function ($validator) use ($request) {
        if (($request['password'] != null) && ($request['confirm_password'] != null)) {
            if ($request['password'] != $request['confirm_password']) {
                $validator->errors()->add('password', 'new password and confirm password must be same');
            }
           }   
          });

          if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
             //dd($request->admin_id);
            $admin = Admin::find($request->admin_id);
            $input['password'] = bcrypt($request->password);
            Admin::where('id', '=', $request->admin_id)->update($input);
            return redirect()->route('login')->with('block', 'password updated successfully');
        }


          
    }



    public function authenticate(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
                        ], [
                    'email.required' => 'Please enter email address.',
                    'email.email' => 'Please enter valid email address.',
                    'password.required' => 'Please enter password.'
        ]);

        $validator->after(function ($validator) use (&$user, $request) {
            $user = Admin::where('email', $request->email)->where('type', '0')->orWhere('type','1')->first();
           // dd($user);
            if (empty($user)) {
                $validator->errors()->add('email', 'Your account does not exist');
            } else {
                if ($user->status == 'inactive') {
                    $validator->errors()->add('email', 'Your account has been disabled. Please contact system admin.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Admin::where('email', $request->email)->where('type', '0')->orWhere('type','1')->first();
                Session::put('admin_logged_in', ['id' => $user->id, 'type' => $user->type]);
                return redirect()->intended('admin/dashboard');
            } else {
                $validator->errors()->add('password', 'Invalid credentials!');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }


}
