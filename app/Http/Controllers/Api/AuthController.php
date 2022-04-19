<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Models\User;
use App\Models\OTP;
use App\Models\NumberPlate;
use App\Models\Notification;
use App\Models\Favourite;
use App\Models\Content;
use App\Models\Help_Support;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function home_screen() {
        $is_favourites = 0;
        $plates = NumberPlate::where('plate_status','0')->where('status','enable')->orderBy('number_plates.id','DESC')->get();
        if($plates){
            foreach($plates as $plate){
                if (Auth::guard('api')->id()) {
                    $favourites = Favourite::where('status','active')->where('plate_id',$plate->id)->get();
                     if(!empty($favourites)){
                        $plate->is_favourites = 1;
                    }else{
                        $plate->is_favourites = 0;
                    }
                }else{
                    $plate->is_favourites = 0;
                }
            }
            $data['plates']=$plate;
            return response()->json([
                "status" => true,
                "data"=> $data,
                "message"=> "home screen data",
                "status_code" =>200,
             ], 200);
        }else{
            return response()->json([
                'message'=> 'Data can not be  uploaded, some error occured.',
                'error_code' => 201,
            ], 201);

        }
    }



    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required',
           
        ],[
            'mobile_number.required'        =>  trans('messages.F022'),
            'country_code.required'         =>  trans('messages.F023'),
        ]);
     
        if($request->mobile_number && $request->country_code){
            $validator->after(function($validator) use(&$user, $request) {
                
                  $mobile_number = User::where('country_code',$request['country_code'])->where('mobile_number',$request['mobile_number'])->whereNotIn('status',['trashed'])->first();
                    if(empty($mobile_number)){
                        $userNumber=[
                            "country_code" => $request->country_code,
                            "mobile_number" => $request->mobile_number,
                        ];

                        $number = User::create($userNumber);
                    }
            });
        }
       
        
        if ($validator->fails()) {
           $this->message = $validator->errors();
           return response()->json([
            "status" => false,
            "data"=> [],
            "message"=>  $this->message,
            "status_code" =>201,
         ], 200);
        }else{
            if($request->mobile_number){
                 $userStatus = User::where('country_code', $request->country_code)->where('mobile_number', $request->mobile_number)->orderBy('created_at', 'desc')->first();
            }
   
            if($userStatus['status'] == 'inactive' || 'active'){

                $otpUser['otp']            =    1111;
                $otpUser['user_id']         =   $userStatus['id'];
                $otp                        =   Otp::create($otpUser);

            }else{

                $this->message = "User Otp cannot be send, some error occured.";
                $this->error_code = 201;
            }
            
            if($request->mobile_number){
                $user = User::where([
                    'country_code'=>$request->country_code,
                    'mobile_number'=>$request->mobile_number,
                    'status'=>'active'
                ])->first();

                $data = $user;
               
            }

            $updateArr = [];
            if($request->device_token != "" && $request->device_type != "") {
                $updateArr['device_token'] = $request->device_token;
                $updateArr['device_type'] = $request->device_type == 'android' ? 'ios' : 'web';
            }
            if ($updateArr) {
                User::where('id',$user->id)->update($updateArr);
            }
            // $token = $user->createToken('MyApp')->accessToken;
            // if($token){
            //   $data['token'] = $token;
              return response()->json([
                "status" => true,
                "data"=> $data,
                "message"=> "login successfully",
                "status_code" =>200,
             ], 200);
           //} 
        }
       
    }




    public function verification(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'otp'         =>  'required',
            'user_id'     =>  'required'
        ],[
            'otp.required'   =>  trans('messages.F008'),
            'user_id.required'   =>  trans('messages.F008'),
        ]);

        $validator->after(function($validator) use($request) {
            $checkOTP = OTP::where([
                'user_id' => $request['user_id'],
                'otp' => $request['otp'],
            ])->latest()->first();
            // print_r($checkOTP);
            if(empty($checkOTP)){
                $validator->errors()->add('error', trans('messages.F009'));
            }
            
        });
     
        if ($validator->fails()) {

            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message,
                "status_code" =>201,
             ], 200);
        }
        else
        {
         
            $user = User::find($request['user_id']);
           
            User::where('id', $request['user_id'])->update([
                'is_otp_verified' => 'yes',
                'status' => 'active',
            ]);

            $updateArr = array();
            if($request->device_token != "" && $request->device_type != "") {
                $updateArr['device_token'] = $request->device_token;
                $updateArr['device_type'] = $request->device_type == 'android' ? 'ios' : 'web';
            }
            if ($updateArr) {
                User::where('id',$request['user_id'])->update($updateArr);
            }
            
            $userTokens = $user->tokens;
            if($userTokens){
                foreach($userTokens as $token) {
                    
                    $token->revoke();   
                }
            }

            $tokenResult =  $user->createToken('MyApp');
            $token = $tokenResult->token;
            $token->save();
             $user['token'] = $tokenResult->accessToken;
            //  $token = $user->createToken('MyApp')->accessToken;
            // if($token){
            //     $user['token'] = $token;
           
               // $data = [];
               // $users = User::find($request['user_id']);
               return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'Otp match successfully',
                "status_code" =>200,
              ], 200);
           //}
        }
          
        
    }


    public function resendOTP(Request $request)
    {
        $user = User::find($request->user_id);
        if($user){
     
            $otpUser['otp']             =   1111;
            $otpUser['user_id']         =   $request->user_id;
            $otp                        =   OTP::create($otpUser);
          
            $data = [];
            return response()->json([
                "status" =>true,
                "status_code" =>200,
                'data' => $data,
                "message" => "OTP send successfully",
                
            ],200);
        }else{
            return response()->json([
                'message'=> 'Otp can not be  send, some error occured.',
                'error_code' => 201,
            ], 201);

        }
    }


    public function favourite_list(Request $request){
        // return $id  = Auth::guard('api')->id();
        $favourites = Favourite::select('*')->with('plates')->where('user_id',Auth::guard('api')->id())
        ->where('status','active')
        ->get();
        if($favourites){
         return response()->json([
            'status' => true,
            'status_code' => 200,
            'data' => $favourites,
            'message' => 'Plate Listing',
            
         ],200); 
        }else{
            return response()->json([
                'status' => true,
                'error_code' => 201,
                'message' => 'some error occured.',
                
             ],201); 

        } 
    }


   
    public function Add_to_favourite(Request $request){
        $validator = \Validator::make($request->all(), [
            'plate_id' =>  'required',
        ],[
            'plate_id.required'     =>  trans("validation.required",['attribute'=>'Plate Id'])
           
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message,
                "status_code" =>201,
             ], 200);
        }else{
            if(Favourite::where('user_id',Auth::guard('api')->id())->where('plate_id',$request->plate_id)->exists()){
                return response()->json([
                 'status' => true,
                  'message'=> 'Plate is already added to Favourite'
                ]);
            }else{
                $Addtofavourite =[
                'user_id' => Auth::guard('api')->id(),
                'plate_id' => $request->plate_id,
                ];
            
                $AddFavourite = Favourite::create($Addtofavourite);
                return response()->json([
                'status' => true,
                'status_code'=>200,
                'data'=>$AddFavourite,
               'message' => 'Plate is Added to favourite',                 
                 ],200);
             } 
        }
        
    }


    public function unFavourite(Request $request){
        $validator = \Validator::make($request->all(), [
            'plate_id' =>  'required',
        ],[
            'plate_id.required'     =>  trans("validation.required",['attribute'=>'Plate Id'])
           
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message,
                "status_code" =>201,
             ], 200);
        }else{
                $UnFavourite = Favourite::where('user_id', Auth::guard('api')->id())->where('plate_id',$request->plate_id)->delete();
                return response()->json([
                'status' => true,
                'status_code' => 200,
                'data'=>'',
                'message' => 'Plate is UnFavourite from favourite list',                 
                 ],200);
             
        }
        
    }

    public function searchPlate(Request $request){
    
        $plate_number_en = $request->plate_number_en;
        $plate_number_ar = $request->plate_number_ar;
        $plate_alphabets_en = $request->plate_alphabets_en;
        $plate_alphabets_ar = $request->plate_alphabets_ar;

        $result = DB::table('number_plates')->orderBy('id','desc')
        ->where(function($query) use ($plate_number_en, $plate_number_ar, $plate_alphabets_en, $plate_alphabets_ar) { 
            if ($plate_number_en)
                $query->where('plate_number_en', 'like', '%'.$plate_number_en.'%');

            if ($plate_number_ar)
                $query->where('plate_number_ar','like', '%'.$plate_number_ar.'%');

            if ($plate_alphabets_en)
                $query->where('plate_alphabets_en','like','%'. $plate_alphabets_en.'%');

            if ($plate_alphabets_ar)
                $query->where('plate_alphabets_ar','like', '%'.$plate_alphabets_ar.'%');

           
        })
        ->where('status', '=', 'enable')->get();
        return response()->json([
              'status' => true,
              'status_code' => 200,
              'data' => $result,
              'message' => 'Plate fetch successfully',
                   
           ],200);
    }

    public function createUserName(Request $request){
        $validator = \Validator::make($request->all(), [
            'user_name' =>  'required',
        ],[
            'user_name.required'     =>  trans("validation.required",['attribute'=>'User name']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });
        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            
            $updateUser = User::where('id',Auth::guard('api')->id())->update(['user_name'=>$request->user_name]);
            $user=User::select('*')->find(Auth::guard('api')->id());
            $data['user'] = $user;
            if($updateUser){
                 return response()->json([
                    'status'=> true,
                    'status_code'=>200,
                     'data' => $data,
                     'message' => 'User name create successfully',
                ], 200);
             }
        }
    }

    // public function editProfile(Request $request){
    //     if (Auth::guard('api')->id()) {
    //         $update['user_name'] = $request['user_name'];
    //         $update['email'] = $request['email'];
              
    //         if($request->profile_pic){
    //             $filename = $request->profile_pic->getClientOriginalName();
    //             $filename = str_replace(" ", "", $filename);
    //             $imageName = time().'.'.$filename;
    //             if(env('APP_ENV') == 'local'){
    //                 $return = $request->profile_pic->move(
    //                 base_path() . '/public/uploads/user/', $imageName);
    //             }else{
    //                 $return = $request->profile_pic->move(
    //                 base_path() . '/../public/uploads/user/', $imageName);
    //             }
    //             $url = url('/uploads/user/');
    //             $update['profile_pic'] = $url.'/'. $imageName;
             
    //         }
        
    //         $update_user = User::where('id',Auth::guard('api')->id())->update($update);
    //         $user=User::select('*')->find(Auth::guard('api')->id());
    //         $data['user']=$user;
    //         if ($update_user) {
    //             return response()->json([
    //                 'status' => true,
    //                 'status_code' =>200,
    //                 'data' => $data,
    //                 'message'=> 'user update successfully',
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'error_code' => 201,
    //                 'data'=>'',
    //                 'message'=> 'User cannot be updated, some error occured.',
    //             ], 201);
    //         }
            
    //     }  
        
    // }

    public function editProfile(Request $request){
        $update=[];
        if($request->user_name){
            $update['user_name'] = $request['user_name'];
        }
        if($request->email){
             $update['email'] = $request['email'];
        }
        if($request->profile_pic){
             $base64_str = substr($request->profile_pic, strpos($request->profile_pic, ",")+1);
            //decode base64 string
            $extension = explode('/', explode(':', substr($request->profile_pic, 0, strpos($request->profile_pic, ';')))[1])[1];
            $filename = 'user-'.Auth::guard('api')->id().time().'.'.$extension;
            define('UPLOAD_DIR', base_path() . '/public/uploads/user/');
            $file = UPLOAD_DIR . $filename;
            file_put_contents($file,base64_decode($base64_str));
            // if(env('APP_ENV') == 'local'){
            //     $return = $request->profile_pic->move(
            //     base_path() . '/public/uploads/user/', $imageName);
            // }else{
            //     $return = $request->profile_pic->move(
            //     base_path() . '/../public/uploads/user/', $imageName);
            // }
            $url = url('/uploads/user/');
            // $update['profile_pic'] = $url.'/'. $imageName;
            $update['profile_pic'] = $url.'/'.$filename;
        }
        if($update){
            $update_user = User::where('id',Auth::guard('api')->id())->update($update);
        }else{
            $update_user=true;
        }
        $user=User::select('*')->find(Auth::guard('api')->id());
        $data['user']=$user;
        if ($update_user) {
            return response()->json([
                'status' => true,
                'status_code' =>200,
                'data' => $data,
                'message'=> 'user update successfully',
            ], 200);
        } else {
            return response()->json([
                'error_code' => 201,
                'data'=>'',
                'message'=> 'User cannot be updated, some error occured.',
            ], 201);
        }
}

    public function aboutUs(){
        $content = Content::select('id', 'description_en')->where('name', 'about_us')->get()->first();
        $data['content'] = $content;
        return response()->json([
            'status' => true,
            'status_code' =>200,
            'data' => $data,
            'message' => 'About us content',
        ], 200);
    }

    public function privacyPolicy(){
        $content = Content::select('id', 'description_en')->where('name', 'privacy_policy')->get()->first();
        $data['content'] = $content;
        return response()->json([
            'status' => true,
            'status_code' =>200,
            'data' => $data,
            'message' => 'Privacy Policy content',
        ], 200);
    }

    public function termsConditions(){
        $content = Content::select('id', 'description_en')->where('name', 'terms_and_conditions')->get()->first();
        $data['content'] = $content;
        return response()->json([
            'status' => true,
            'status_code' =>200,
            'data' => $data,
            'message' => 'Term And Condition content',
        ], 200);
    }


    public function myPlates(Request $request){
        // return $id = Auth::guard('api')->id();
        $plates = NumberPlate::select('*')->where('user_id',Auth::guard('api')->id())->where('status','enable')->orderBy('id','desc')->get();
        $myPlates = [];
         if($plates){
             foreach($plates as $plate){
                 if($plate->plate_status == 0){
                    $plate->plate_status = "active"; 
                 }elseif($plate->plate_status == 1){
                    $plate->plate_status = "pending" ;
                 }else{
                    $plate->plate_status = "sold"   ;
                 }
                array_push($myPlates, $plate);
               
             }
              $data['plate'] = $myPlates;
              return response()->json([
                'status' => true,
                'status_code'=>200,
                'data' => $data,
                'message'=> 'Plates listing',
            ], 200);
        }else
        {
            return response()->json([
                'error_code' => 201,
                'data'=>'',
                'message'=> 'User have no plate',
            ], 201);

        }  
    }


    public function uploadPlate(Request $request){

        $validator = \Validator::make($request->all(), [
            'email'              =>  'required',
            'calling_number_type'     =>  'required',

            
        ],[
            'email.required'     =>  trans('messages.F044'),
            'calling_number_type.required' => trans('message. F044')

        ]);

        $validator->after(function($validator) use($request) {
            if($request['plate_number_en']){
                $plate_number_en = NumberPlate::where('plate_number_en',$request['plate_number_en'])->where('status',['enable'])->first();
                if ($plate_number_en) {
                    $validator->errors()->add('plate_number_en', trans('duplicate entry'));
                }
            }
            if($request['plate_number_ar']){
                $plate_number_ar = NumberPlate::where('plate_number_ar',$request['plate_number_ar'])->where('status',['enable'])->first();
                if ($plate_number_ar) {
                    $validator->errors()->add('plate_number_ar', trans('duplicate entry'));
                }
            }
            if($request['plate_alphabets_en']){
                $plate_alphabets_en = NumberPlate::where('plate_alphabets_en',$request['plate_alphabets_en'])->where('status',['enable'])->first();
                if ($plate_alphabets_en) {
                    $validator->errors()->add('plate_alphabets_en', trans('duplicate entry'));
                }
            }
            if($request['plate_alphabets_ar']){
                $plate_alphabets_ar = NumberPlate::where('plate_alphabets_ar',$request['plate_alphabets_ar'])->where('status',['enable'])->first();
                if ($plate_alphabets_ar) {
                    $validator->errors()->add('plate_alphabets_ar', trans('duplicate entry'));
                }
            }
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message,
                "status_code" =>201,
             ], 201);
        }else{
            $is_agree = "disagree";
            $insert=[
                'user_id'              =>Auth::guard('api')->id(),
                'plate_number_en'      =>$request->plate_number_en,
                'plate_number_ar'      => $request->plate_number_ar,
                'plate_alphabets_en'   => $request->plate_alphabets_en,
                'plate_alphabets_ar'   => $request->plate_alphabets_ar,
                'price'                => $request->price,
                'email'                => $request->email,   
            ];
            
           if($request->price_type == 'negotiable'){

              $insert['price_type'] = "negotiable";

             } 
              elseif($request->price_type == 'fixed')   {

               $insert['price_type'] = "fixed";
             } 
           
            if($request->calling_number_type== 'registered number'){
                $registered_number  = User::select('country_code','mobile_number')->where('id',Auth::guard('api')->id())->first();
                //  return $registered_number->country_code;
                 if($registered_number){
                    $insert['calling_country_code'] = $registered_number->country_code;
                    $insert['calling_number'] = $registered_number->mobile_number;
                    $insert['calling_number_type'] = "registered _number";

                 }
             }
             elseif($request->calling_number_type == 'new number'){
                $insert['calling_country_code'] = $request->calling_country_code;
                $insert['calling_number'] = $request->calling_number;
                $insert['calling_number_type'] = 'new_number';

            }
          
            if($request['whatsapp_number_type'] == 'registered number'){
                $registered_number  = User::select('country_code','mobile_number')->where('id',Auth::guard('api')->id())->first();
                if($registered_number){
                   $insert['whatsapp_country_code'] = $registered_number->country_code;
                   $insert['whatsapp_number'] = $registered_number->mobile_number;
                   $insert['whatsapp_number_type'] = "registered_number";

                }
            }
            elseif($request->whatsapp_number_type == 'new number'){
           
               $insert['whatsapp_country_code'] = $request->whatsapp_country_code;
               $insert['whatsapp_number'] = $request->whatsapp_number;
               $insert['whatsapp_number_type'] = 'new_number';

           }
           

          if($is_agree == 'disagree'){
              $insert['plate_status'] = "0";
          }else{
            $insert['plate_status'] = "1";
          }

          // return $insert;
            $add=NumberPlate::create($insert);
            if($add){
                return response()->json([
                    'status' => true,
                    'status_code'=>200,
                    'data' => $add,
                    'message'=> 'Plate Upload Successfully',
                ], 200);
            }else{
                return response()->json([
                    'error_code' => 201,
                    'data'=>'',
                    'message'=> 'Plate cannot be added, some error occured.',
                ], 201);
            }
        }
        

    }


    public function notification(){

     $notification = Notification::where('user_id',Auth::guard('api')->id())->where('read','unread')->get();
     if($notification){
         foreach($notification as $notifications){
           $update['read'] = 'read';
           $update_status = Notification::where('id',$notifications->id)->update($update);
         }
     }
     $read_notification = Notification::with('plate','user_detail')->where('user_id',Auth::guard('api')->id())->where('read','read')->get();
     if($read_notification){
        return response()->json([
            'status' => true,
            'status_code'=>200,
            'data' => $read_notification,
            'message'=> 'Notification list',
        ], 200);
    }else{
        return response()->json([
            'error_code' => 201,
            'data'=>'',
            'message'=> 'notification cannot be uploaded, some error occured.',
        ], 201);
    }
    }


    public function helpSupport(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'subject' => 'required',
                    'message' => 'required',
                   
                        ], [
                    'email.required' => trans('validation.required', ['attribute' => 'email']),
                    'subject.required' => trans('messages.F032'),
                    'message.required' => trans('messages.F033'),
                    
        ]);

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $data['email'] = $request->email;
            $data['subject'] = $request->subject;
            $data['message'] = $request->message;
            $data['user_id'] = (Auth::guard('api')->id() ? Auth::guard('api')->id() : 1);

            $userData = Help_support::create($data);
            $help_support = Help_support::where('user_id',Auth::guard('api')->id())->get();
            if($help_support){
              return response()->json([
                'status' => true,
                'status_code'=>200,
                'data' => $help_support,
                'message'=> 'message add successfully',
              ], 200);
            }else{

                return response()->json([
                    'error_code' => 201,
                    'data'=>'',
                    'message'=> 'User cannot be updated, some error occured.',
                ], 201);

            }
        }

    }

    public function filterPlate(Request $request){
        //return $id = Auth::guard('api')->id();
        if(NumberPlate::where('user_id', Auth::guard('api')->id())->exists()){
             $get_plate = NumberPlate::where('plate_status', $request->plate_status)->orderBy('id','desc')->get();
             return response()->json([
                'status' => true,
                'status_code'=>200,
                'data' => $get_plate,
                'message'=> 'plate filter successfully',
              ], 200);
         }else{
            return response()->json([
                'error_code' => 201,
                'data'=>'',
                'message'=> 'some error occured.',
            ], 201);

         }

    }
    
}
  