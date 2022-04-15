<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Help_support;
use DB;

class QueryController extends Controller
{
   
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $query = Help_support::with('user')->get();
            $data['query'] = $query;
             return view('admin.query.query_list')->with($data);
        }
    }

    public function filter_list(Request $request) {
        $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
        if ($request->input('start_date') && $request->input('end_date')) {
            $query = Help_support::where('status', '<>', 99)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $query = Help_support::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
        }
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['query'] = $query;
        return view('admin.query.query_list')->with($data);
    }
  
    public function query_delete(Request $request ){
         $id = $request->input('id');
          $query_delete = Help_support::find($id);
         $delete = $query_delete->delete();
         if ($delete) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'query deleted successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting event']);
       }
 }

 public function queryDetail(Request $request, $id=null){
    $id = base64_decode($id);
    $query = Help_support::find($id);
    $data['query'] = $query;
    if($data){
     return view('admin.query.query_detail')->with($data);
 }else{
    return redirect('admin/query-management')->with('error', 'query not found');
 } 

 }
  
}
