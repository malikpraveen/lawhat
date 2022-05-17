<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Models\User;
use App\Models\Otp;
use App\Models\NumberPlate;
use App\Models\Notification;
use App\Models\Favourite;
use App\Models\Content;
use App\Models\Help_Support;
use App\Models\TimePeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function home_screen() {
        $is_favourites = 0;
        $timePeriod=TimePeriod::find(1);
        $time_period=$timePeriod->first_time_period;
        $grace_period=$timePeriod->grace_period;
        $plateList=[];
        $plates = NumberPlate::where('plate_status','1')->where('status','enable')->orderBy('number_plates.id','DESC')->get();
        // echo '<pre>';print_r($plates);die;
        if($plates){
            foreach($plates as $plate){
                // echo Auth::guard('api')->id();die;
                if (Auth::guard('api')->id()) {
                    $favourites = Favourite::where('status','active')->where('plate_id',$plate->id)->where('user_id',Auth::guard('api')->id())->first();
                     if(!empty($favourites)){
                        $plate->is_favourites = 1;
                    }else{
                        $plate->is_favourites = 0;
                    }
                }else{
                    $plate->is_favourites = 0;
                }
                $expiry_date=date('Y-m-d H:i:s',strtotime("+".$time_period." days",strtotime($plate->created_at)));
                // echo '<br>'.date('Y-m-d H:i:s');
                if($expiry_date > date('Y-m-d H:i:s')){
                    array_push($plateList,$plate);
                }else{
                    $notification=Notification::where('plate_id',$plate->id)->orderBy('id','desc')->first();
                    if($notification){
                        if($notification->status == 'pending'){
                            $grace_period_date= date('Y-m-d H:i:s',strtotime("+".$grace_period." days",strtotime($expiry_date)));
                            if($grace_period_date > date('Y-m-d H:i:s')){
                                array_push($plateList,$plate);
                            }
                        }else if($notification->status == 'yes'){
                            array_push($plateList,$plate);
                        }else{
                            // do not display
                        }
                    }else{
                        $grace_period_date= date('Y-m-d H:i:s',strtotime("+".$grace_period." days",strtotime($expiry_date)));
                            if($grace_period_date > date('Y-m-d H:i:s')){
                                array_push($plateList,$plate);
                            
                                Notification::create([
                                    'user_id'=>$plate->user_id,
                                    'plate_id'=>$plate->id,
                                    'title_en'=>'Would you like to renew your plate?',
                                    'title_ar'=>'هل ترغب في تجديد لوحتك؟',
                                    'body_en'=>'Plate Number - '.$plate->plate_alphabets_en.' '.$plate->plate_number_en,
                                    'body_ar'=>'رقم لوحة - '.$plate->plate_alphabets_ar.' '.$plate->plate_number_ar,
                                    'read'=>'0',
                                    'status'=>'pending'
                                ]);
                            }
                    }
                }
            }
            $data['plate']=$plateList;
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
            'mobile_number.required'        => trans("validation.required",['attribute'=>'mobile_number']),
            'country_code.required'         =>  trans("validation.required",['attribute'=>'country_code']),
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
                    }else{
                        if ($mobile_number->status == 'blocked') {
                            $validator->errors()->add('mobile_number', 'Your account has been blocked. Please contact system admin.');
                        }
                    }
            });
        }
       
        
        if ($validator->fails()) {
           $this->message = $validator->errors();
           return response()->json([
            "status" => false,
            "data"=> [],
            "message"=>  $this->message->first(),
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
            'otp.required'   =>  trans("validation.required",['attribute'=>'otp']),
            'user_id.required'   =>  trans("validation.required",['attribute'=>'user_id']),
        ]);

        $validator->after(function($validator) use($request) {
            $checkOTP = Otp::where([
                'user_id' => $request['user_id'],
                'otp' => $request['otp'],
            ])->latest()->first();
            // print_r($checkOTP);
            if(empty($checkOTP)){
                $validator->errors()->add('error', 'Invalid OTP');
            }
            
        });
     
        if ($validator->fails()) {

            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
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
            unset($user['tokens']);
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
            $otp                        =   Otp::create($otpUser);
          
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
                "message"=>  $this->message->first(),
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
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 200);
        }else{
                $UnFavourite = Favourite::where('user_id', Auth::guard('api')->id())->where('plate_id',$request->plate_id)->delete();
                return response()->json([
                'status' => true,
                'status_code' => 200,
                'data'=>[],
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
        // if($request->email){
             $update['email'] = $request['email'];
        // }
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
                'message'=> 'User update successfully',
            ], 200);
        } else {
            return response()->json([
                'error_code' => 201,
                'data'=>[],
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
                 if($plate->plate_status == 1){
                    $plate->plate_status = "active"; 
                 }elseif($plate->plate_status == 0){
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
                'data'=>[],
                'message'=> 'User have no plate',
            ], 201);

        }  
    }


    public function uploadPlate(Request $request){
        $timePeriod=TimePeriod::first();
        $time_period=$timePeriod->first_time_period;

        $validator = \Validator::make($request->all(), [
            // 'email'              =>  'required',
            'calling_number_type'     =>  'required',

            
        ],[
            // 'email.required'     =>  trans("validation.required",['attribute'=>'email']),
            'calling_number_type.required' => trans("validation.required",['attribute'=>'calling_number_type'])

        ]);

        $validator->after(function($validator) use($request) {
            // if($request['plate_number_en']){
            //     $plate_number_en = NumberPlate::where('plate_number_en',$request['plate_number_en'])->where('status',['enable'])->first();
            //     if ($plate_number_en) {
            //         $validator->errors()->add('plate_number_en', trans('duplicate entry'));
            //     }
            // }
            // if($request['plate_number_ar']){
            //     $plate_number_ar = NumberPlate::where('plate_number_ar',$request['plate_number_ar'])->where('status',['enable'])->first();
            //     if ($plate_number_ar) {
            //         $validator->errors()->add('plate_number_ar', trans('duplicate entry'));
            //     }
            // }
            // if($request['plate_alphabets_en']){
            //     $plate_alphabets_en = NumberPlate::where('plate_alphabets_en',$request['plate_alphabets_en'])->where('status',['enable'])->first();
            //     if ($plate_alphabets_en) {
            //         $validator->errors()->add('plate_alphabets_en', trans('duplicate entry'));
            //     }
            // }
            // if($request['plate_alphabets_ar']){
            //     $plate_alphabets_ar = NumberPlate::where('plate_alphabets_ar',$request['plate_alphabets_ar'])->where('status',['enable'])->first();
            //     if ($plate_alphabets_ar) {
            //         $validator->errors()->add('plate_alphabets_ar', trans('duplicate entry'));
            //     }
            // }
            
            
            if($request['plate_number_ar'] &&  $request['plate_alphabets_ar']){
                $plate_number_abr = NumberPlate::where('plate_number_ar',$request['plate_number_ar'])->where('plate_alphabets_ar',$request['plate_alphabets_ar'])->where('status',['enable'])->first();
                if ($plate_number_abr) {
                    $validator->errors()->add('plate_number_ar', trans('duplicate entry'));
                   $validator->errors()->add('plate_alphabets_ar', trans('duplicate entry'));
                }
            }
            if($request['plate_number_en']  && $request['plate_alphabets_en']){
                $plate_number_eng = NumberPlate::where('plate_number_en',$request['plate_number_en'])->where('plate_alphabets_en',$request['plate_alphabets_en'])->where('status',['enable'])->first();
                if ($plate_number_eng) {
                   $validator->errors()->add('plate_number_en', trans('duplicate entry'));
                   $validator->errors()->add('plate_alphabets_en', trans('duplicate entry'));
                }
            }
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 201);
        }else{
            $is_agree = "disagree";
            $expiry_date=date('Y-m-d H:i:s',strtotime("+".$time_period." days"));
            $insert=[
                'user_id'              =>Auth::guard('api')->id(),
                'plate_number_en'      =>$request->plate_number_en,
                'plate_number_ar'      => $request->plate_number_ar,
                'plate_alphabets_en'   => $request->plate_alphabets_en,
                'plate_alphabets_ar'   => $request->plate_alphabets_ar,
                'price'                => $request->price,
                'email'                => $request->email,   
                'expiry_date'          => $expiry_date,
                'added_by'             =>'0'
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
                    $insert['calling_number_type'] = "registered number";

                 }
             }
             elseif($request->calling_number_type == 'new number'){
                $insert['calling_country_code'] = $request->calling_country_code;
                $insert['calling_number'] = $request->calling_number;
                $insert['calling_number_type'] = 'new number';

            }
          
            if($request['whatsapp_number_type'] == 'registered number'){
                $registered_number  = User::select('country_code','mobile_number')->where('id',Auth::guard('api')->id())->first();
                if($registered_number){
                   $insert['whatsapp_country_code'] = $registered_number->country_code;
                   $insert['whatsapp_number'] = $registered_number->mobile_number;
                   $insert['whatsapp_number_type'] = "registered number";

                }
            }
            elseif($request->whatsapp_number_type == 'new number'){
           
               $insert['whatsapp_country_code'] = $request->whatsapp_country_code;
               $insert['whatsapp_number'] = $request->whatsapp_number;
               $insert['whatsapp_number_type'] = 'new number';

           }
           

        //   if($is_agree == 'disagree'){
        //       $insert['plate_status'] = "0";
        //   }else{
        //     $insert['plate_status'] = "1";
        //   }
        
          if($request->plate_status == '0'){
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
                    'data'=>[],
                    'message'=> 'Plate cannot be added, some error occured.',
                ], 201);
            }
        }
        

    }


    public function notification(){
        $read_notification = Notification::with('plate','user_detail')->where('user_id',Auth::guard('api')->id())->where('status','pending')->get();
        $notification = Notification::where('user_id',Auth::guard('api')->id())->where('read','0')->get();
        if($notification){
            foreach($notification as $notifications){
               $update['read'] = '1';
               $update_status = Notification::where('id',$notifications->id)->update($update);
             }
         }
        //  $read_notification = Notification::with('plate','user_detail')->where('user_id',Auth::guard('api')->id())->where('read','1')->get();
        //  if($read_notification){
            return response()->json([
                'status' => true,
                'status_code'=>200,
                'data' => $read_notification,
                'message'=> 'Notification list',
            ], 200);
        // }else{
        //     return response()->json([
        //         'error_code' => 201,
        //         'data'=>[],
        //         'message'=> 'notification cannot be uploaded, some error occured.',
        //     ], 201);
        // }
    }


    public function helpSupport(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'subject' => 'required',
                    'message' => 'required',
                   
                        ], [
                    'email.required' => trans('validation.required', ['attribute' => 'email']),
                    'subject.required' => trans("validation.required",['attribute'=>'subject']),
                    'message.required' => trans("validation.required",['attribute'=>'message']),
                    
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
                'message'=> 'Message add successfully',
              ], 200);
            }else{

                return response()->json([
                    'error_code' => 201,
                    'data'=>[],
                    'message'=> 'User cannot be updated, some error occured.',
                ], 201);

            }
        }

    }

    public function filterPlate(Request $request){
        //return $id = Auth::guard('api')->id();
        if(NumberPlate::where('user_id', Auth::guard('api')->id())->exists()){
             $get_plate = NumberPlate::where('plate_status', $request->plate_status)->where('user_id',Auth::guard('api')->id())->orderBy('id','desc')->get();
             if($get_plate){
                 foreach($get_plate as $plate){
                     if($plate->plate_status == 1){
                        $plate->plate_status = "active"; 
                     }elseif($plate->plate_status == 0){
                        $plate->plate_status = "pending" ;
                     }else{
                        $plate->plate_status = "sold"   ;
                     }
               
                 }
             }
             return response()->json([
                'status' => true,
                'status_code'=>200,
                'data' => $get_plate,
                'message'=> 'Plate filter successfully',
              ], 200);
         }else{
            return response()->json([
                'error_code' => 201,
                'data'=>[],
                'message'=> 'Some error occured.',
            ], 201);

         }

    }
    
    public function myProfile(){
        
        $user=User::select('id','user_name','email','country_code','mobile_number','profile_pic')->where('id',Auth::guard('api')->id())->first();
        $data=$user;
           return response()->json([
            'status' => true,
            'status_code'=>200,
            'data' => $data,
            'message'=> 'My profile fetched successfully',
          ], 200);
    }
    
    public function updatePlateStatus(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'plate_id' => 'required'
                        ], [
                    'plate_id.required' => 'plate id is required field'
        ]);
        $validator->after(function ($validator) use ($request) {
            if ($request->plate_id) {
                $getPlate = NumberPlate::where('id', $request->plate_id)->where('user_id', Auth::guard('api')->id())->first();
                if (!$getPlate) {
                    $this->error_code = 201;
                    $validator->errors()->add('plate_id', "This plate is not found.");
                }
            }
        });
        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 201);
        } else {
            $updatePlate = [
                'plate_status' => $request->plate_status
            ];
            $update = NumberPlate::where('id', $request->plate_id)->where('user_id', Auth::guard('api')->id())->update($updatePlate);
            if ($update) {
                return response()->json([
                    "status" => true,
                    "data"=> $update,
                    "message"=>  'Plate status change successfully',
                    "status_code" =>200,
                 ], 200);
            } else {
               return response()->json([
                    'error_code' => 201,
                    'data'=>[],
                    'message'=> 'Plate status cannot be updated, some error occured.',
                ], 201);
            }
        }
    }
    
    public function deletePlate(Request $request){
        $validator = \Validator::make($request->all(), [
            'plate_id' => 'required'
                ], [
            'plate_id.required' => 'plate id is required field'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 201);
        }else {
          $delete = NumberPlate::where(['user_id' => Auth::guard('api')->id(), 'id' => $request->plate_id])->delete();
         if ($delete) {
            return response()->json([
                "status" => true,
                "data"=> $delete,
                "message"=>  'Plate delete successfully',
                "status_code" =>200,
             ], 200);
       } else {
        return response()->json([
            'error_code' => 201,
            'data'=>[],
            'message'=> 'some error occured, Try again later',
        ], 201);
       }
       }
    }
    
    public function editPlate(Request $request){
        $validator = \Validator::make($request->all(), [
            // 'email'              =>  'required',
            'calling_number_type'     =>  'required',
            'plate_id'                     =>  'required',
        ],[
            // 'email.required'     =>  'email is required field',
            'calling_number_type.required' => 'calling number type is required field',
            'plate_id.required'           => 'Plate_id is required field'
        ]);
        $validator->after(function($validator) use($request) {
            // if($request['plate_number_en'] && $request['plate_id']){
            //     $plate_number_en = NumberPlate::where('id','<>',$request['plate_id'])
            //     ->where('plate_number_en',$request['plate_number_en'])
            //     // ->where('plate_alphabets_en',$request['plate_alphabets_en'])
            //     ->where('status',['enable'])->first();
            //     if ($plate_number_en) {
            //         $validator->errors()->add('plate_number_en', 'duplicate entry');
            //     }
            // } 
            // if($request['plate_number_ar'] && $request['plate_id']){
            //     $plate_number_ar = NumberPlate::where('id','<>',$request['plate_id'])->where('plate_number_ar',$request['plate_number_ar'])->where('status',['enable'])->first();
            //     if ($plate_number_ar) {
            //         $validator->errors()->add('plate_number_ar', 'duplicate entry');
            //     }
            // }
            // if($request['plate_alphabets_en'] && $request['plate_id']){
            //     $plate_alphabets_en = NumberPlate::where('id','<>',$request['plate_id'])->where('plate_alphabets_en',$request['plate_alphabets_en'])->where('status',['enable'])->first();
            //     if ($plate_alphabets_en) {
            //         $validator->errors()->add('plate_alphabets_en', 'duplicate entry');
            //     }
            // }
            // if($request['plate_alphabets_ar'] && $request['plate_id']){
            //     $plate_alphabets_ar = NumberPlate::where('id','<>',$request['plate_id'])->where('plate_alphabets_ar',$request['plate_alphabets_ar'])->where('status',['enable'])->first();
            //     if ($plate_alphabets_ar) {
            //         $validator->errors()->add('plate_alphabets_ar', 'duplicate entry');
            //     }
            // }
            
            
            if($request['plate_number_ar'] &&  $request['plate_alphabets_ar'] && $request['plate_id']){
                $plate_number_abr = NumberPlate::where('id','<>',$request['plate_id'])->where('plate_number_ar',$request['plate_number_ar'])->where('plate_alphabets_ar',$request['plate_alphabets_ar'])->where('status',['enable'])->first();
                if ($plate_number_abr) {
                    $validator->errors()->add('plate_number_ar', trans('duplicate entry'));
                   $validator->errors()->add('plate_alphabets_ar', trans('duplicate entry'));
                }
            }
            if($request['plate_number_en']  && $request['plate_alphabets_en'] && $request['plate_id']){
                $plate_number_eng = NumberPlate::where('id','<>',$request['plate_id'])->where('plate_number_en',$request['plate_number_en'])->where('plate_alphabets_en',$request['plate_alphabets_en'])->where('status',['enable'])->first();
                if ($plate_number_eng) {
                   $validator->errors()->add('plate_number_en', trans('duplicate entry'));
                   $validator->errors()->add('plate_alphabets_en', trans('duplicate entry'));
                }
            }
        });
        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 201);
        }else{
            // $is_agree = "disagree";
            $update=[
                'user_id'              =>Auth::guard('api')->id(),
                'plate_number_en'      =>$request->plate_number_en,
                'plate_number_ar'      => $request->plate_number_ar,
                'plate_alphabets_en'   => $request->plate_alphabets_en,
                'plate_alphabets_ar'   => $request->plate_alphabets_ar,
                'price'                => $request->price,
                'email'                => $request->email,
            ];
           if($request->price_type == 'negotiable'){
              $update['price_type'] = "negotiable";
             }
              elseif($request->price_type == 'fixed')   {
               $update['price_type'] = "fixed";
             }
            if($request->calling_number_type== 'registered_number'){
                $registered_number  = User::select('country_code','mobile_number')->where('id',Auth::guard('api')->id())->first();
                //  return $registered_number->country_code;
                 if($registered_number){
                    $update['calling_country_code'] = $registered_number->country_code;
                    $update['calling_number'] = $registered_number->mobile_number;
                    $update['calling_number_type'] = "registered_number";
                 }
             }
             elseif($request->calling_number_type == 'new_number'){
                $update['calling_country_code'] = $request->calling_country_code;
                $update['calling_number'] = $request->calling_number;
                $update['calling_number_type'] = 'new_number';
            }
            if($request['whatsapp_number_type'] == 'registered_number'){
                $registered_number  = User::select('country_code','mobile_number')->where('id',Auth::guard('api')->id())->first();
                if($registered_number){
                   $update['whatsapp_country_code'] = $registered_number->country_code;
                   $update['whatsapp_number'] = $registered_number->mobile_number;
                   $update['whatsapp_number_type'] = "registered_number";
                }
            }
            elseif($request->whatsapp_number_type == 'new_number'){
               $update['whatsapp_country_code'] = $request->whatsapp_country_code;
               $update['whatsapp_number'] = $request->whatsapp_number;
               $update['whatsapp_number_type'] = 'new_number';
           }
           
           
           if($request->plate_status == '0'){
              $update['plate_status'] = "0";
          }else{
              $update['plate_status'] = "1";
          }
          
        //   if($is_agree == 'disagree'){
        //       $update['plate_status'] = "0";
        //   }else{
        //     $update['plate_status'] = "1";
        //   }
          // return $insert;
            $add=NumberPlate::where('id',$request->plate_id)->update($update);
            if($add){
                return response()->json([
                    'status' => true,
                    'status_code'=>200,
                    'data' => $add,
                    'message'=> 'Plate Update Successfully',
                ], 200);
            }else{
                return response()->json([
                    'error_code' => 201,
                    'data'=>[],
                    'message'=> 'Plate cannot be added, some error occured.',
                ], 201);
            }
        }
    }
    
    
    public function notificationResponse(Request $request){
        $validator = \Validator::make($request->all(), [
            'notification_id' => 'required',
            'status' => 'required'
                ], [
            'notification_id.required' => 'notification id is required field',
            'status.required' => 'status is required field'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
            return response()->json([
                "status" => false,
                "data"=> [],
                "message"=>  $this->message->first(),
                "status_code" =>201,
             ], 201);
        }else {
          $status = Notification::where('id',$request->notification_id)->where('user_id',Auth::guard('api')->id())->update(['status'=>$request->status]);
         if ($status) {
             $notification=Notification::where('id',$request->notification_id)->where('user_id',Auth::guard('api')->id())->first();
             NumberPlate::where('id',$notification->plate_id)->update(['status'=>'disable']);
            return response()->json([
                "status" => true,
                "data"=> [],
                "message"=>  ($request->status == 'yes'?'Plate display time extended':'Plate has been removed').' successfully',
                "status_code" =>200,
             ], 200);
       } else {
        return response()->json([
            'error_code' => 201,
            'data'=>[],
            'message'=> 'some error occured, Try again later',
        ], 201);
       }
       }
    }
}
  