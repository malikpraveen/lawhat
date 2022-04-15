@extends('admin.layout.master')

@section('content')

<div class="content-wrapper">
            <div class="content-header sty-one">
                <h1>Help & Support Management</h1> 
                <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Query</li>
        </ol>
            </div>
<div class="content"> 
<div class="card mb-2">
            <div class="card-body">
            <form method="post" action="{{route('admin.query.filter')}}">
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
 <div class="row">  
 <div class="col-md-12"> 
        <div class="card"> 
        <div class="card-header mb-4">
                <h5 class="card-title">Help And Support List</h5>
            </div> 
                    <div class="card-body"> 
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
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                       <th>Sr No.</th>  
                                        <th>User Name </th>    
                                        <th>Email Id </th>  
                                        <th>Subject</th> 
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($query as $key=>$query)
                                    <tr> 
                                        <td>{{$key+1}}</td>
                                        <td class="property-link">{{$query->user->user_name}}</td> 
                                        <td>{{$query->email}}</td>
                                        <td class="property-link">{{$query->subject}}</td>
                                        <td>{{$query->message}}</td>
                                        <td>{{date('d-m-Y',strtotime($query->created_at))}}</td>
                                        <td><a href="<?= url('admin/query-detail/'.base64_encode($query->id)) ?>" class="composemail"><i class="fa fa-eye"></i></a>
                                        <a href="#" onclick="deleteData(this,'{{$query->id}}');" class="composemail"><i class="fa fa-trash"></i></a>
                                    </td>
                                    </tr>  
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                </div>
              </div>
 
@endsection
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
 <script>
      function deleteData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/query-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Query has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }


        
</script>
    