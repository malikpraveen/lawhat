@extends('admin.layout.master2')

@section('content')
<div class="container-fluid  wl-login">
    <div class="container ml-0 pl-0">
    <div class="login-box" style=" position: relative; right:-900px;">
            <div class="form-section">
                <div class="login-logo">
                    <img src="{{asset('assets/admin/images/logo.png')}}">
                </div>
                <h4 class="forgot-heading mt-2 mb-5 text-center">Please enter the OTP received on your Email Address</h4>
                <form method="POST" action="{{url('admin/checkOTP')}}">
                    {{ csrf_field() }}
                    <p class="forgot-para">Please Enter the OTP</p>
                    <div class="form-group has-feedback mb-1">
                        <input type="text" name="otp" class="form-control" placeholder="enter otp">
                        
                        @if ($errors->has('otp'))
                            <div class="help-block">
                                <strong class="text-danger">{{ $errors->first('otp') }}</strong>
                            </div>
                        @endif
                        <input type="hidden" name="admin_id" id="otp"  value="{{$id}}" class="form-control" placeholder="">
                    </div>
                    <!-- <a href="javascript:void(0)" id="regenerateOTP" class="text-dark " ></span> <span class="pull-left">Resend OTP</span></a> <br> -->
                    <button id="regenerateOTP"  class="btn btn-warning btn_shadow" style="border-radius: 10;" >Resend OTP </button>
                     <span id="timer"></span> 
                   
                    <div>
                        <div class="col-xs-4 m-t-4">
                            <button type="submit" class="btn-block btn-flat loginbth">Submit</button>
                           
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
    //function onclickFunction(obj)
    $("#regenerateOTP").click(function(e){
      e.preventDefault();
      disableResend();
        timer(60);
      $.ajax({
        type: "post",
        url: "{{ url('admin/resend_otp') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'admin_id': $('#otp').val(),
        },
        success: function (data) {
            swal({ title: "Sweet!", text: "One time password  is sent on your email", timer: 2000, imageUrl: "../images/thumbs-up.jpg" });
        },
        error: function (data) {
            swal({ title: "Error!", text: "We are facing technical error!", type: "error", confirmButtonText: "Ok" });
            return false;
        }
      });
});
    
    function disableResend()
{
 $("#regenerateOTP").attr("disabled", true);
 timer(60);
  //$('.regenerateOTP').prop('disabled', true);
  setTimeout(function() {
    // enable click after 1 second
    //$("#regenerateOTP").attr("disabled", false);
   $('#regenerateOTP').removeAttr("disabled");
    //$('.disable-btn').prop('disabled', false);
  }, 60000); // 1 second delay
}

let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML =  m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  swal({ title: "Sweet!", text: "OTP expired. Pls. try again." });
}
</script>
@endsection

