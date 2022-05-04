@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Help & Support Detail</h1> 
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row mt-3">
                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <p>{{$query->message}}</p>
                            </div>
                            <div class="col-md-12 text-right"> <a href="{{url('admin/query-management')}}" class="composemail">Go Back</a>
                                <a class="composemail" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Reply</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="collapse" id="collapseExample">
                                <form method='post' id="addForm" enctype="multipart/form-data" action="{{url('admin/query/reply',[base64_encode($query->id)])}}">
                                        @csrf
                                    <div class="card card-body">
                                    <div class="form-group">
                                        <label>Your Message</label>
                                        <textarea class="form-control validate" name="reply" cols="6" rows="6" placeholder="Write here...."></textarea>
                                        <div class="mt-4 mb-4 text-right">  <a style="cursor:default;" onclick="closeTab(this);" class="composemail">Cancel</a>   
                                        <button type="button" style="margin: 15px; height: 32px; margin-top: -5px;"  class="mybtns pull-right" onclick="validate(this);" class="btn btn-primary">Send </button> 
                                        </div>
                                    </div>
                                  </div>
                               </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <!-- <script>
        function sendReply(obj, id) {
            if (id) {
                var reply = $(":input[name=reply]").val();
                if (reply) {
                    $.ajax({
                        url: "<?= url('admin/query/reply') ?>",
                        type: 'post',
                        data: 'id=' + id + '&reply=' + reply + '&_token=<?= csrf_token() ?>',
                        success: function (data) {
                            if (data.error_code == "200") {
                                alert(data.message);
                                closeTab();
                                location.reload();
                            } else {
                                $("#error").html(data.message);
//                            alert(data.message);
                            }
                        }
                    });
                } else {
                    $("#error").html("Message field is required");
                }
            } else {
                alert("Something went wrong");
            }
        }
</script> -->
<script>
        function closeTab(obj) {
            $('.collapse').removeClass('show');
            $('#openForm').show();
            $(":input[name=reply]").val("");
            $("#error").html("");
        }
    </script>
@endsection