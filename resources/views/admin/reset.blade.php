@extends('admin.layout.master2')

@section('content')
<div class="container-fluid  wl-login">
    <div class="container ml-0 pl-0">
    <div class="login-box" style=" position: relative; right:-900px;">
            <div class="form-section">
                <div class="login-logo">
                    <img src="{{asset('assets/admin/images/logo.png')}}">
                </div>
                <form method="POST" action="{{url('admin/ConfirmPassword')}}">
                    {{ csrf_field() }}
                    <p class="forgot-para">Please Create Your New Password</p>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" value="{{old('password')}}" class="form-control sty1" placeholder="New Password">
                        <input type="hidden" name="admin_id" class="form-control" value="{{$id}}">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        @if ($errors->has('confirm_password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                            </span>
                        @endif
                    </div>   
                        <div class="col-xs-4 m-t-4">
                            <button type="submit" class="btn-block btn-flat loginbth">Submit</button>
                        </div>
                    </div> 
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
@endsection