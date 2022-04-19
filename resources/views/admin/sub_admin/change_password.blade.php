@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Change Password</h1> 
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Change Password</li>
        </ol>
    </div>

    <div class="content">
               <!-- @if(session()->has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif -->
       <div class="card mb-2">
            <div class="card-header mb-4">
               <h5 class="card-title">Change Password</h5>
           </div>
           @if(session()->has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif
           <form method="POST" action="{{url('admin/subadmin/change_password')}}">
                    {{ csrf_field() }}
           <div class="card-body">
            
              <div class="col-md-6 mb-4 offset-3">
              <div class="col-md-12 mb-4">
              <level>Old Password</level>
              <input type="text" name="old_password" class="form-control" placeholder="Old Password">
                     @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('old_password') }}</strong>
                            </span>
                        @endif
                   </div>
                   <div class="col-md-12 mb-4">
                   <level>New Password</level>
                   <input type="text" name="new_password" class="form-control" placeholder="New Password">
                     @if ($errors->has('new_password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
                            </span>
                        @endif
                   </div>
                   <div class="col-md-12 mb-4">
                   <level>Confirm Password</level>
                   <input type="text" name="confirm_password" class="form-control" placeholder="Confirm Password">
                          @if ($errors->has('confirm_password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                            </span>
                        @endif
                   </div>
                 
                
                   <div class="text-center mb-4 mt-4">
                   <button type="submit" class="btn btn-primary">Submit</button>
                
                    </div>
           
                </div>
                
           </div>
           </form>
       </div>
  </div>
@endsection

