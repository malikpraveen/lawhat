@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Subscription</h1> 
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i>Sub Admin</li>
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
               <h5 class="card-title">Add Sub Admin</h5>
           </div>
           <form method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/sub_admin/submit')}}" >
                      @csrf
           <div class="card-body">
            
              <div class="col-md-6 mb-4 offset-3">
                 <div class="col-md-12 mb-4">
                     <input type="text" class="form-control validate" name="name"  placeholder="Enter Sub Admin Name">
                      <p class="text-danger" id="nameError"></p>
                   </div>
                   <div class="col-md-12 mb-4">
                     <input type="text" class="form-control validate" name="email"  placeholder="Enter Email">
                      <p class="text-danger" id="emailError"></p>
                   </div>
                   <div class="col-md-12 mb-4">
                     <input type="text" class="form-control validate" name="password"  placeholder="Enter Password">
                      <p class="text-danger" id="passwordError"></p>
                   </div>  
                   <div class="text-center mb-4 mt-4">
                        <button type="button" onclick="validate(this);" class="btn btn-primary">Submit</button>
                
                    </div>
           
                </div>
                
           </div>
           </form>
       </div>
       

        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Sub Admin List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Sr. No.</th>
                                <th>Sub Admin Name</th>
                                <th>Email</th>
                                <th>Registration Date</th> 
                                <th>Status</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @if($sub_admin)
                            @foreach($sub_admin as $k=>$sub_admins)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$sub_admins->name}}</td>
                                <td>{{$sub_admins->email}}</td>
                                <td>{{date('d-m-Y',strtotime($sub_admins->created_at))}}</td>
                                <td> <div class="mytoggle">
                                        <label class="switch">
                                        <input type="checkbox" onchange="changeStatus(this, '<?= $sub_admins->id ?>');" <?= ( $sub_admins->status == 'active' ? 'checked' : '') ?>><span class="slider round"> </span> 
                                        </label>
                                    </div></td>
                                <td>  <a href=" <?= url('admin/edit-subadmin/' . base64_encode($sub_admins->id)); ?> " class="composemail"><i class="fa fa-edit"></i></a></td> 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
    

    @endsection

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
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/sub_admin/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Sub Admin  Status has been Updated \n Click OK to refresh the page",
                                            icon : "success",
                                        })
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        } else {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                $(obj).prop('checked', false);
                            } else {
                                $(obj).prop('checked', true);
                            }
                            return false;
                        }
                    });
        }
    </script>


