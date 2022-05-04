@extends('admin.layout.master')

@section('content')
<style>


    .chosen-single{
        /*margin-top: 10px;*/
        width: 100%;
        max-width: 350px;
        height: 38px !important;
        border-radius: 5px;
        /*background: -webkit-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%) !important;*/
        border: 1px solid #ccc !important;
        color: #495057;
        font-size: 14px;
        box-shadow:0;

    }

    .chosen-single span{
        padding-top: 5px;
    }

    .chosenImage-container .chosen-single {
        /*padding-left: 2px;*/
        background-position: left 7px top 8px;
    }

</style>

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>user List</h1> 
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> User </li>
        </ol>
    </div>
    <div class="content">  
    <div class="card mb-2">
            <div class="card-body">
            <form method="post" action="{{route('admin.user.filter')}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label>From </label>
                                <input type="date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label>To </label>
                                <input type="date" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                            </div>
                        </div> 
                        <div class="col-md-12 col-xs-12">
                            <p id="formError" class="text-danger"></p>
                        </div>
                        <div class="col-md-4 col-xs-6 mt-1">
                        <a href="#filter" onclick="filterList(this)"; class="btn btn-primary pt-2 pb-2 w-100 mt-1">Search</a>
                        </div> 
                        <div class="col-md-4 col-xs-6 mt-1">
                            <a href='<?= url('admin/user-management') ?>' class="btn btn-primary pt-2 pb-2 w-100 mt-1">Reset</a>
                        </div>     
                    </div> 
                </form>  
            </div>   
        </div>   
        <div class="card">
            @if(session()->has('error'))  
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('error') }}
            </div>
            @endif
            <div class="card-body">  

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Registerted Number</th>
                                <th>Registration Date</th>  
                                <th>Status</th>  
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @if($users)
                            @foreach($users as $k=>$user)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$user->user_name}}</td>
                                <td>{{$user->country_code}}&nbsp;&nbsp;{{$user->mobile_number}}</td>
                                <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                                <td> <div class="mytoggle">
                                        <label class="switch">
                                        <input type="checkbox" onchange="changeStatus(this, '<?= $user->id ?>');" <?= ( $user->status == 'active' ? 'checked' : '') ?>><span class="slider round"> </span> 
                                        </label>
                                    </div></td>
                                <td><a href="{{url('admin/user-detail/'.base64_encode($user->id))}}" class="composemail"><i class="fa fa-eye"></i></a></td> 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>

    
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
                                var status = 'blocked';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/user/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "User Status has been Updated \n Click OK to refresh the page",
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
    <script>
       function filterList(obj){
        if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
        $("#formError").html('Select filter attribute');
        } else{

        if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != ''){
        $('form').submit();
        } else{
        if ($(':input[name=start_date]').val() != ''){
        $("#formError").html('End date is required');
        } else if ($(':input[name=end_date]').val() != ''){
        $("#formError").html('Start date is required');
        } else{
        $("#formError").html('Select filter attribute');
        }
        }
        }

        }
    
 </script>
    

    @endsection