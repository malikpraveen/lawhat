<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\NumberPlate;
use DB;

class PlateController extends Controller
{
   
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $data['plate'] = NumberPlate::select('*')->get();
             return view('admin.plate.plate_list')->with($data);
        }
    }


    public function upload_Plate(Request $request){

        $validator = \Validator::make($request->all(), [
            'email'              =>  'required',
            'calling_number_type'     =>  'required',

            
        ],[
            'email.required'     =>  trans('messages.F044'),
            'calling_number_type.required' => trans('message. F044')

        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $is_agree = "disagree";
            $insert=[
                'user_id'              =>Auth::guard('api')->id(),
                'plate_number_en'      =>$request->plate_number_en,
                // 'plate_number_ar'      => $request->plate_number_ar,
                'plate_alphabets_en'   => $request->plate_alphabets_en,
                // 'plate_alphabets_ar'   => $request->plate_alphabets_ar,
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
                    //$insert['calling_number_type'] = "registered _number";

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
                   //$insert['whatsapp_number_type'] = "registered_number";

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
            if ($add) {
                return redirect()->back()->with('success','sub Admin added successfully');
             } else {
                 return redirect()->back()->with('error', 'Some error occurred while adding sub admin');
             }
        }
        

    }

    public function plateDetail(Request $request, $id=null){
        $id = base64_decode($id);
        $plate = NumberPlate::with('user')->find($id);
        $data['plate'] = $plate;
        if($data){
         return view('admin.plate.plate_detail')->with($data);
     }else{
        return redirect('admin/plate-management')->with('error', 'query not found');
     } 
 
     }

     public function plate_delete(Request $request ){
         $id = $request->input('id');
         $plate_delete = NumberPlate::find($id);
        $delete = $plate_delete->delete();
        if ($delete) {
          return response()->json(['status' => true, 'error_code' => 200, 'message' => 'query deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting event']);
      }
}

    public function upload_plate_page() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            if(Session::get('admin_logged_in')['type']=='1'){
             return view('admin.plate.upload_plate');
            }
        }
    }


  
}
