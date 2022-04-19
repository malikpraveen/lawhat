<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\NumberPlate;
use App\Models\TimePeriod;
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
        if(Session::get('admin_logged_in')['type']=='1'){
         $user_id = Session::get('admin_logged_in')['id'];
             $insert=[
                'user_id'              =>$user_id,
                'plate_number_en'      =>$request->plate_number_en,
                'plate_number_ar'      => $request->plate_number_ar,
                'plate_alphabets_en'   => $request->plate_alphabets_en,
                'plate_alphabets_ar'   => $request->plate_alphabets_ar,
                // 'price_type'            => $request->type,
                'price'                 =>$request->price,
                'email'                => $request->email, 
                'user_name'            =>$request->name,
                'calling_number'       =>$request->calling_number,
                'whatsapp_number'      =>$request->whatsapp_number,
            ];
            
           if($request->type == 'noFixed'){

              $insert['price_type'] = "negotiable";

             } 
              elseif($request->type == 'fixed')   {

               $insert['price_type'] = "fixed";
             } 
     
          // return $insert;
            $add=NumberPlate::create($insert);
            if ($add) {
                return redirect()->back()->with('success','Plate added successfully');
             } else {
                 return redirect()->back()->with('error', 'Some error occurred while adding plate');
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

  public function submit(Request $request){
    if(Session::get('admin_logged_in')['type']=='0'){
       $data =[
            'first_time_period' => $request->firstNotification,
           'grace_period' =>  $request->secondNotification,
           'notification_id'    => 1,
       ];

       $add=TimePeriod::create($data);
       if ($add) {
           return redirect()->back()->with('success','Time Period added successfully');
        } else {
            return redirect()->back()->with('error', 'Some error occurred while adding plate');
        }
       

    }

  }
  
}
