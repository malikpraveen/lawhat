
@extends('admin.layout.master2')

@section('content')
<div class="container-fluid  wl-login">
    <div class="container ml-0 pl-0">
    <div class="login-box" style=" position: relative; right:-900px;">
            <div class="form-section">
                <div class="login-logo">
                    <img src="{{asset('assets/admin/images/logo.png')}}">
                </div>
                <p class="forgot-para">Please enter your registered Email Address

to receive the OTP</p>
                <form  method="POST"  id="sign_in" enctype="multipart/form-data"  action="{{url('admin/forgotten')}}" autocomplete="off">
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
                    <button type="button" onclick="validate(this);" class="btn btn-primary mybtns-send ">Submit</button> 
                </form>
            </div>
        </div>
    </div>
</div>
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
            var formData = $("#sign_in").find(".validate:input").not(':input[type=button]');
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
                $("#sign_in").submit();
            } else {
                return false;
            }

            
        }
    </script>
@endsection
