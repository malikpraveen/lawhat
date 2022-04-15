<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{
    public function index(Request $request){
        if(!Auth::guard('admin')->check()){
            return redirect()->intended('admin/login');
        }
        else{
            if(Session::get('admin_logged_in')['type']=='0'){
            $data['content'] = Content::orderBy('id','asc')->get(); 
            return view('admin.content.content_list')->with($data);
            }
        }  
       
    }


    public function content_edit(Request $request, $id=null){
        if(Session::get('admin_logged_in')['type']=='0'){
        $id = base64_decode($id);
        $data['edit_content'] = Content::where('id',$id)->first();
        if($data){
            return view('admin.content.edit_content')->with($data);

        }else{
            return redirect()->back()->with('error','details not found');
        }
    }
       
    }

    public function update(Request $request, $id=null){
        if(Session::get('admin_logged_in')['type']=='0'){
        $id = base64_decode($id);
        $data=[
            "description_en" => $request->input('contenten'),
            "description_ar" => $request->input('contentar'),

        ];
  
   $update = Content::find($id)->update($data);
   if($update){
       return redirect('admin/content-management')->with('success', ' update successfully.');
   }
   else {
       return redirect()->back()->with('error', 'Some error occurred while update ');
   }

   }
}



}
