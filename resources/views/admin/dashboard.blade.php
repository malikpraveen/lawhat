@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Dashboard</h1> 
        <ol class="breadcrumb">
            <li><i class=""></i> Dashboard </li>
        </ol>
    </div>

    <div class="content"> 
        <div class="row">
            <div class="col-lg-6 col-xs-6 m-b-3">
            <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                    <div class="card-body"><span class="info-box-icon bg-green"><i class="icon-user"></i></span>
                        <div class="info-box-content"> <span class="info-box-number"></span>{{$total_user}} <span class="info-box-text">
                                Total Users </span> </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6 col-xs-6 m-b-3">
            <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                    <div class="card-body"><span class="info-box-icon bg-green"><i class="icon-newspaper"></i></span>
                        <div class="info-box-content"> <span class="info-box-number"></span>{{$total_plates}} <span class="info-box-text">
                                Total Plates </span> </div>
                    </div>
                </div>
            </div> 
        </div>  

        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Recent Users</h5>
            </div>
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
                                var status = 'inactive';
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
    @endsection

    