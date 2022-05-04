@extends('admin.layout.master')
@section('content')
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<div class="content-wrapper">
  <div class="content-header sty-one">
    <h1>User Detail</h1> 
  </div>
  <div class="content userdetails">
  <div class="card">
            <div class="row ">
                <div class="col-lg-12 ">
                    <div class="user-profile-box  ">
                        <div class="box-profile text-white d-flex">
                         <div class="col-md-6">
                           <h3 class="profile-username">User's Information</h3> 
                            <img class="profile-user-img img-responsive img-circle m-b-2" style="margin:0" src="<?= $user->profile_pic?$user->profile_pic:asset('assets/admin/images/user.png') ?>" alt="User profile picture">
                            <h3 class="profile-username">{{$user->user_name}}</h3>
                         </div>
                            <div class="col-md-5">
                               <div class="form-group">
                                <input class="form-control validate" type="text" name="number" readonly="true" value="{{$user->user_name}}" placeholder="Mobile Number">
                                <p class="text-danger" id="sizeError"></p>
                              </div>
                      
                        
                               <div class="form-group">
                                <input class="form-control validate" type="text" name="email" readonly="true" value="{{$user->email}}" placeholder=" Email">
                                <p class="text-danger" id="sizeError"></p>
                            </div>
                           
                               <div class="form-group">
                                <input class="form-control validate" type="text" name="registration_date" readonly="true" value="{{date('d-m-Y',strtotime($user->created_at))}}" placeholder="Registration Date">
                                <p class="text-danger" id="sizeError"></p>
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="mytoggle" >
                              <label class="switch">
                              <input type="checkbox" onchange="changeStatus(this, '<?= $user->id ?>');" <?= ( $user->status == 'active' ? 'checked' : '') ?>><span class="slider round"> </span> 
                           </div>
                        </div>
                       </div>
                        
                    </div>
                    
                </div>
            </div> 
        </div>
     <div class="card mt-4">
      <div class="card-header mb-4">
        <h5 class="card-title">Uploaded Plates</h5>
      </div>
      <div class="card-body">
      <div class="container">
      <div class="row">
    @foreach($user->number_plate as $plate)
    @if($loop->odd)
    <div class="col-md-6 mt-5">
      <div class="card" style="width: 25rem">
        <div class="card-body card-outline">
          <div class="row">
            <div class="col-md-4 ">
              <div class="left-text">
                <h1>{{$plate->plate_number_ar}}</h1>
                <p>{{$plate->plate_number_en}}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="logo-area text-center">
                <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
                <level>logo</level>
              </div>
            </div>
            <div class="col-md-4">
              <div class="right-text">
                <h1>{{$plate->plate_alphabets_ar}}</h1>
                <p>{{$plate->plate_alphabets_en}}</p>
              </div>
            </div>
          </div>
          <div class="middle-line"></div>
          <div class="d-flex  justify-content-between align-items-center">
            <div class=" social-icons">
            <a href="#" data-toggle="modal" data-target="#modalTC">
              <i class="fa fa-envelope ml-3"></i>
              <i class="fa fa-commenting ml-3"></i>
              <i class="fa fa-phone ml-3"></i></a>
            </div>
            <h1 class="pricee mr-3">{{$plate->price}}</h1>
          </div>

          <div class="middle-line"></div>
          <div class="d-flex justify-content-between">
            <!-- <a href="{{url('admin/plate_detail/'.base64_encode($plate->id))}}"  class="btn btn-primary b-t-n" >Details </a> -->

            <a href="#" onclick="deleteData(this,'{{$plate->id}}');" class="btn btn-primary b-t-n" style="width: 100% !important;">Delete</a>
          </div>
        </div>
        <!-- Modal -->
 <div class="modal fade" id="modalTC" role="dialog">
  <div class="modal-dialog">
   <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header" style="background-color: #DBD301;">
      <h4 class="modal-title">User Details</h4>
    </div>
    <div class="modal-body">
    <p>Email:- {{$plate->email}}</p>
      <p>Whatsapp Number:- {{$plate->calling_country_code}}&nbsp;&nbsp;{{$plate->calling_number}}</p>
      <p>Calling Number:- {{$plate->whatsapp_country_code}}&nbsp;&nbsp;{{$plate->whatsapp_number}}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </div>
 </div>
      </div>
    </div>
    @endif
   @endforeach
   @foreach($user->number_plate as $plate)
    @if($loop->even)
    <div class="col-md-6 mt-5">
      <div class="card" style="width: 25rem">
        <div class="card-body card-outline">
          <div class="row">
            <div class="col-md-4 ">
              <div class="left-text">
                <h1>{{$plate->plate_number_ar}}</h1>
                <p>{{$plate->plate_number_en}}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="logo-area text-center">
                <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
                <level>logo</level>
              </div>
            </div>
            <div class="col-md-4">
              <div class="right-text">
                <h1>{{$plate->plate_alphabets_en}}</h1>
                <p>{{$plate->plate_alphabets_en}}</p>
              </div>
            </div>
          </div>
          <div class="middle-line"></div>
          <div class="d-flex  justify-content-between align-items-center">
            <div class=" social-icons">
            <a href="#" data-toggle="modal" data-target="#modalTC">
              <i class="fa fa-envelope ml-3"></i>
              <i class="fa fa-commenting ml-3"></i>
              <i class="fa fa-phone ml-3"></i></a>
            </div>
            <h1 class="pricee mr-3">{{$plate->price}}</h1>
          </div>

          <div class="middle-line"></div>
          <div class="d-flex justify-content-between">
          <!-- <a href="{{url('admin/plate_detail/'.base64_encode($plate->id))}}"  class="btn btn-primary b-t-n" >Details </a> -->

          <a href="#" onclick="deleteData(this,'{{$plate->id}}');" class="btn btn-primary b-t-n" style="width: 100% !important;">Delete</a>
          </div>
        </div>
        <!-- Modal -->
 <div class="modal fade" id="modalTC" role="dialog">
  <div class="modal-dialog">
   <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header" style="background-color: #DBD301;">
      <h4 class="modal-title">User Details</h4>
    </div>
    <div class="modal-body">
    <p>Email:- {{$plate->email}}</p>
      <p>Whatsapp Number:- {{$plate->calling_country_code}}&nbsp;&nbsp;{{$plate->calling_number}}</p>
      <p>Calling Number:- {{$plate->whatsapp_country_code}}&nbsp;&nbsp;{{$plate->whatsapp_number}}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
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
  </div>

  <style>
    input[type=text] {
    background: white;
    border: none;
    border-bottom: 1px solid white;
    
    
}
  </style>

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
  @endsection