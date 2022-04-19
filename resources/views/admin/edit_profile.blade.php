@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1> Admin</h1> 
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Profile </li>
        </ol>
    </div>

    <div class="content">
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
       <div class="card mb-2">
            <div class="card-header mb-4">
               <h5 class="card-title">Edit Profile</h5>
           </div>
           <form method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/edit_profileUpdate',[base64_encode($edit_admin->id)])}}" >
                        @csrf
           <div class="card-body">
            
              <div class="col-md-6 mb-4 offset-3">
              <div class="col-md-12 mb-4">
                     <input type="text" class="form-control validate" name="name" value="{{ old('name', $edit_admin['name']) }}"   placeholder="Enter Sub Admin Name">
                      <p class="text-danger" id="nameError"></p>
                   </div>
                   <div class="col-md-12 mb-4">
                     <input type="text" class="form-control validate" name="email" value="{{ old('email', $edit_admin['email']) }}" placeholder="Enter Email">
                      <p class="text-danger" id="emailError"></p>
                   </div>
                   <div class="col-md-12 mb-4">
                      <div class="form-group eyepassword">
                          <input class="form-control validate" id='password' type="password" name="password" value="{{old('password')}}" placeholder="••••••••">
                          <i class="fa fa-eye" onclick="showPassword(this, 'password');"></i>
                          <p class="text-danger" id="passwordError"></p>
                       </div>
                   </div>
                 
                
                   <div class="text-center mb-4 mt-4">
                        <button type="button" onclick="validate(this);" class="btn btn-primary">Submit</button>
                
                    </div>
           
                </div>
                
           </div>
           </form>
       </div>
  </div>
@endsection
<script>
  function showPassword(obj, id) {
        if ($('#' + id).attr('type') == 'text') {
            $('#' + id).attr('type', 'password');
            $(obj).removeClass('fa-eye-slash');
            $(obj).addClass('fa-eye');
        } else {
            $('#' + id).attr('type', 'text');
            $(obj).removeClass('fa-eye');
            $(obj).addClass('fa-eye-slash');
        }
    }
</script>
<script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            $(formData).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    
                $("#" + name + "Error").html("This field is required");
                flag = false;
                    
                    
                } else {

                }
            });
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>