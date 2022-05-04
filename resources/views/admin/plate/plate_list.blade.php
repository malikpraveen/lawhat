@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
<div class="content-header sty-one">
   <h1>Plates Management</h1>
   <ol class="breadcrumb">
      <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i> Plate </li>
   </ol>
</div>
@if(Session::get('admin_logged_in')['type']=='1')
<a href="<?= url('admin/upload_plate_page')?>"  class="btn btn-primary pt-2 pb-2 w-45 mt-1 float-center" style="position: relative; left: 80%;" >Upload Plate</a>
@endif
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
@if(Session::get('admin_logged_in')['type']=='0')
<div class="card mb-4">
   <div class="card-header mb-4">
      <h5 class="card-title">Add Notification Period</h5>
   </div>
   <div class="card-body">
      <form method="POST" id="form1"  enctype="multipart/form-data" action="{{url('admin/notificationPeriod/submit')}}" >
         @csrf
         <div class="row mb-4 ">
            <div class="col-md-6">
               <div class="form-group">
                  <input class="form-control validate alphanum" type="text" name="firstNotification" placeholder="Enter First Notification Time Period (Ex. 10 days)">
                  <p class="text-danger" id="roomnaneError"></p>
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <input class="form-control validate alphanum" type="text" name="secondNotification"  placeholder="Enter Grace Period For Second Notification (Ex. 5 days)">
                  <p class="text-danger" id="feeError"></p>
               </div>
            </div>
         </div>
         <!-- <div class="row mt-4">
            <div class="col-md-12"> 
                <button type="button" onclick="validate(this);" class="mybtns pull-right" style=" margin-inline: 398px;">Submit</button>
            </div>
            </div> -->
      </form>
   </div>
</div>
@endif
<div class="card mb-2">
            <div class="card-body">
            <form method="post" action="{{route('admin.plate.filter')}}">
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
                            <a href='<?= url('admin/plate-management') ?>' class="btn btn-primary pt-2 pb-2 w-100 mt-1">Reset</a>
                        </div>     
                    </div> 
                </form>  
            </div>   
        </div>   
<div class="card mb-4">
   <div class="card-header mb-4">
      <h5 class="card-title">Plate List</h5>
   </div>
   <div class="card-body">
      <div class="container">
         <div class="row">
            @foreach($plate as $plates)
            @if($loop->odd)
            <div class="col-md-6 mt-5">
               <div class="card" style="width: 25rem">
                  <div class="card-body card-outline">
                     <div class="row">
                        <div class="col-md-4 ">
                           <div class="left-text">
                              <h1 style="letter-spacing: 10px;">{{$plates->plate_number_ar}}</h1>
                              <p style="letter-spacing: 10px;">{{$plates->plate_number_en}}</p>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="logo-area text-center">
                              <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
                              <label>Logo</label>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="right-text">
                              <h1 style="letter-spacing: 10px;">{{$plates->plate_alphabets_ar}}</h1>
                              <p style="letter-spacing: 10px;">{{$plates->plate_alphabets_en}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="middle-line"></div>
                     <div class="d-flex  justify-content-between align-items-center">
                      
                           <div class=" social-icons">
                           <a href="#" data-toggle="modal" data-target="#modalTC">
                              <i class="fa fa-envelope ml-3"></i>
                              <i class="fa fa-commenting ml-3"></i>
                              <i class="fa fa-phone ml-3"></i>
                              </a>
                        </div>
                      
                        <h1 class="pricee mr-3">{{$plates->price}}</h1>
                     </div>
                     <div class="middle-line"></div>
                     <div class="d-flex justify-content-between">
                        <a href="{{url('admin/plate_detail/'.base64_encode($plates->id))}}"  class="btn btn-primary b-t-n" >Details </a>
                        @if(Session::get('admin_logged_in')['type']=='1')
                      
                        <select class="btn btn-primary b-t-n " id="mySelect" onchange="changePlateStatus(this, '<?= $plates->id ?>');" >
                           
                           <option id="rating1"  value="0"  @if ($plates->plate_status == '1' || '2') disabled ? selected @endif  >Pending</option>
                          
                           <option id="rating2" value="1" @if ($plates->plate_status == '1') selected @endif >Active</option>
                           <option id="rating3" value="2" @if ($plates->plate_status == '2') selected @endif  >Sold</option>
                       </select>
                       @endif
                        <a href="#" onclick="deleteData(this,'{{$plates->id}}');" class="btn btn-primary b-t-n">Delete</a>
                     </div>
                  </div>
               </div>
               <!-- Modal -->
               <div class="modal fade" id="modalTC" role="dialog">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header" style="background-color: #DBD301;">
                           <h4 class="modal-title">User Detail</h4>
                        </div>
                        <div class="modal-body">
                           <p>Email:- {{$plates->email}}</p>
                           <p>Whatsapp Number:- {{$plates->calling_country_code}}&nbsp;&nbsp;{{$plates->calling_number}}</p>
                           <p>Calling Number:- {{$plates->whatsapp_country_code}}&nbsp;&nbsp;{{$plates->whatsapp_number}}</p>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
            @endforeach
            @foreach($plate as $plates)
            @if($loop->even)
            <div class="col-md-6 mt-5">
               <div class="card" style="width: 25rem">
                  <div class="card-body card-outline">
                     <div class="row">
                        <div class="col-md-4 ">
                           <div class="left-text">
                              <h1 style="letter-spacing: 10px;">{{$plates->plate_number_ar}}</h1>
                              <p style="letter-spacing: 10px;">{{$plates->plate_number_en}}</p>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="logo-area text-center">
                              <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
                              <label>Logo</label>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="right-text">
                              <h1 style="letter-spacing: 10px;">{{$plates->plate_alphabets_ar}}</h1>
                              <p style="letter-spacing: 10px;">{{$plates->plate_alphabets_en}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="middle-line"></div>
                     <div class="d-flex  justify-content-between align-items-center">
                       
                           <div class=" social-icons">
                           <a href="#" data-toggle="modal" data-target="#modalTC">
                              <i class="fa fa-envelope ml-3"></i>
                              <i class="fa fa-commenting ml-3"></i>
                              <i class="fa fa-phone ml-3"></i>
                              </a>
                        </div>
                       
                        <h1 class="pricee mr-3">{{$plates->price}}</h1>
                     </div>
                     <div class="middle-line"></div>
                     <div class="d-flex justify-content-between">
                        <a href="{{url('admin/plate_detail/'.base64_encode($plates->id))}}"  class="btn btn-primary b-t-n" >Details </a>
                        @if(Session::get('admin_logged_in')['type']=='1')
                      
                      <select class="btn btn-primary b-t-n " id="mySelect" onchange="changePlateStatus(this, '<?= $plates->id ?>');" >
                         
                         <option id="rating1"  value="0"  @if ($plates->plate_status == '1' || '2') disabled ? selected @endif >Pending</option>
                        
                         <option id="rating2" value="1" @if ($plates->plate_status == '1') selected @endif >Active</option>
                         <option id="rating3" value="2" @if ($plates->plate_status == '2') selected @endif  >Sold</option>
                     </select>
                     @endif
                        <a href="#" onclick="deleteData(this,'{{$plates->id}}');" class="btn btn-primary b-t-n">Delete</a>
                     </div>
                  </div>
               </div>
               <!-- Modal -->
               <div class="modal fade" id="modalTC" role="dialog">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header" style="background-color: #DBD301;">
                           <h4 class="modal-title">User Detail</h4>
                        </div>
                        <div class="modal-body">
                           <p>Email:- {{$plates->email}}</p>
                           <p>Whatsapp Number:- {{$plates->calling_country_code}}&nbsp;&nbsp;{{$plates->calling_number}}</p>
                           <p>Calling Number:- {{$plates->whatsapp_country_code}}&nbsp;&nbsp;{{$plates->whatsapp_number}}</p>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
               @endforeach
         </div>
      </div>
   </div>
</div>
</div>
<script>
   document.getElementById('form1')
   .addEventListener('keyup', function(event) {
           if (event.code === 'Enter')
           {
               event.preventDefault();
               document.querySelector('form').submit();
           }
       });
</script>
<script>
   function myFunction(obj) {
  var value = document.getElementById("mySelect").value;
  $.ajax({
                type: 'POST',
                url: '<?= url('admin/changePlateStatus') ?>',
                data: { 'value': value ,'_token':'{{ csrf_token()}}'},
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                     $('#employee_name').html(data.fullname);
                     },
                error:function(){
                }
            });
  
  
}

function changePlateStatus(obj, id) {
   var value = document.getElementById("mySelect").value;
   //  alert(value);
            swal({
                title: "Are you sure?",
                text: " status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/changePlateStatus') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + value + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Plate  Status has been Updated ",
                                            icon : "success",
                                        })
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        
                   
        }

</script>

@endsection
<script>
   function deleteData(obj, id){
         
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
                     url : "<?= url('admin/plate_delete') ?>",
                     type : "POST",
                     data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                     success: function(data){
                         swal({
                             title: "Success!",
                             text : "Plate has been deleted \n Click OK to refresh the page",
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