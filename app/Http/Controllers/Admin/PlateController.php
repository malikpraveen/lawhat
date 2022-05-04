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
            $data['plate'] = NumberPlate::select('*')->orderBy('id','desc')->get();
             return view('admin.plate.plate_list')->with($data);
        }
    }


    public function upload_Plate(Request $request){
        $timeperiod = TimePeriod::first();
         $time_period = $timeperiod->first_time_period;
        if(Session::get('admin_logged_in')['type']=='1'){
             $plate_number_ar     = $request->get('pname').$request->get('pname1').$request->get('pname2').$request->get('pname3');
            $plate_number_en      = $request->get('plate_number_en').$request->get('plate_number_en1').$request->get('plate_number_en2').$request->get('plate_number_en3');
             $plate_alphabets_ar   = $request->get('pname4').$request->get('pname5').$request->get('pname6');
             $plate_alphabets_en   = $request->get('plate_alphabets_en').$request->get('plate_alphabets_en1').$request->get('plate_alphabets_en2');

            if($plate_number_ar &&  $plate_alphabets_ar  ){
                $plate_number_abr = NumberPlate::where('plate_number_ar',$plate_number_ar)->where('plate_alphabets_ar',$plate_alphabets_ar)->where('status',['enable'])->first();
                if ($plate_number_abr) {
                    return redirect()->back()->with('error','Plate already added');
                }
            }
            if($plate_number_en  && $plate_alphabets_en  ){
                $plate_number_eng = NumberPlate::where('plate_number_en',$plate_number_en)->where('plate_alphabets_en',$plate_alphabets_en)->where('status',['enable'])->first();
                if ($plate_number_eng) {
                    return redirect()->back()->with('error','Plate already added');
                }
            }
           
           

         $user_id = Session::get('admin_logged_in')['id'];
         $expiry_date = date('Y-m-d H:m:i', strtotime("+". $time_period . "days"));
              $insert=[
                'user_id'              =>$user_id,
                'plate_number_ar'      => $plate_number_ar,
                'plate_number_en'      =>  $plate_number_en,
                'plate_alphabets_ar'   => $plate_alphabets_ar,
                'plate_alphabets_en'   => $plate_alphabets_en,
                'price_type'            => $request->type,
                'price'                 =>$request->price,
                'email'                => $request->email, 
                'user_name'            =>$request->name,
                'calling_number'       =>$request->calling_number,
                'whatsapp_number'      =>$request->whatsapp_number,
                'plate_status'         =>'1',
                'expiry_date'          =>$expiry_date,
                'added_by'            =>'1'
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
           
       ];

       $add=TimePeriod::create($data);
       if ($add) {
           return redirect()->back()->with('success','Time Period added successfully');
        } else {
            return redirect()->back()->with('error', 'Some error occurred while adding plate');
        }
       

    }

  }

  public function changePlateStatus(Request $request){
    if(Session::get('admin_logged_in')['type']=='1'){
    $id = $request->input('id');
    $value = $request->input('action');
    $update = NumberPlate::find($id)->update(['plate_status'=>$value]);
    if ($update) {
        return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Plate Status updated successfully']);
    } else {
        return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
    }
}


}


public function filter_list(Request $request) {
    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
    $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
    if ($request->input('start_date') && $request->input('end_date')) {
        $plate = NumberPlate::where('status', '<>', 99)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'DESC')
                ->get();
    } else {
        $plate = NumberPlate::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
    }
    $data['start_date'] = $request->input('start_date');
    $data['end_date'] = $request->input('end_date');
    $data['plate'] = $plate;
    return view('admin.plate.plate_list')->with($data);
}
  
}
