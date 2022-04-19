
@extends('admin.layout.master2')

@section('content')
<div class="container-fluid  wl-login">
    <div class="container ml-0 pl-0">
    <div class="login-box" style=" position: relative; right:-900px;">
            <div class="form-section">
                <div class="login-logo">
                    <img src="{{asset('assets/admin/images/logo.png')}}">
                </div>
                <h3 class="mt-2 mb-5">Hi, Welcome Back..!!</h3>
                <p>Login to your account</p>
                @if(session()->has('block'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('block') }}
                </div>
                @endif
                <form method=post id="addForm" enctype="multipart/form-data" action="{{url('admin/dologin')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="email" name="email" class="form-control validate" value="{{old('email')}}" placeholder="Email">
                        <p class="text-danger" id="emailError"></p>
                        @if ($errors->has('email'))
                        <div class="help-block">
                            <strong class="text-danger text-small">{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="form-group eyepassword">
                        <input type="password" name="password" id="password" class="form-control validate" value="{{old('password')}}" placeholder="Password">
                        <i class="fa fa-eye" onclick="showPassword(this,'password')"></i>
                        <p class="text-danger" id="passwordError"></p>
                        @if ($errors->has('password'))
                        <div class="help-block">
                            <strong class="text-danger text-small">{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div>
                    <a href="{{url('admin/forgot')}}">Forgot Password?</a>
                    <button type="button" onclick="validate(this);" class="btn btn-primary mybtns-send " style="background: #DBD301">Sign In</button> 
                </form>
            </div>
        </div>
    </div>
</div>
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
@endsection
