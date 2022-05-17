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
  
    <div class="content">
        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Plate Detail</h5>
            </div>
            <div class="card-body">
            <div class="container">
            <div class="container">
  <div class="row">
    <div class="col-md-6 mt-5">
      <div class="card" style="width: 25rem">
        <div class="card-body card-outline">
          <div class="row">
            <div class="col-md-4 ">
              <div class="left-text">
                <h1 style="letter-spacing: 10px;">{{$plate->plate_number_ar}}</h1>
                <p style="letter-spacing: 10px;">{{$plate->plate_number_en}}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="logo-area">
                <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="right-text">
                <h1 style="letter-spacing: 10px;">{{$plate->plate_alphabets_ar}}</h1>
                <p style="letter-spacing: 10px;">{{$plate->plate_alphabets_en}}</p>
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
            <!-- <button type="button" class="btn btn-primary b-t-n">Details</button> -->
            <!-- <a href="#" onclick="deleteData(this,'{{$plate->id}}');" class="btn btn-primary b-t-n" style="width: 100% !important;">Delete</a> -->
          </div>
        </div>
      </div>
      <div class="form-group">
          <label for="exampleInputPassword1">
            Uploading Date:-
            <span class="ml-2" style="color: black; font-size: 13px">
            {{date('d-m-Y',strtotime($plate->created_at))}}
            </span>
          </label>
        </div>
    </div>
    <div class="col-md-6 mt-5">
      <h5>User's Informations</h5>
      <!-- <i
        class="fa fa-user-circle user-profile-icon mt-2"
        aria-hidden="true"
      ></i> -->
      <td><img class="profile-user-img img-responsive img-circle m-b-2" style="margin:0"  alt="User profile picture" src="<?= $plate->user->profile_pic?$plate->user->profile_pic:asset('assets/admin/images/user.png') ?>"></td>
      <div class="form-group mt-1">
        <label for="exampleInputPassword1" style="color: #949292">
          {{$plate->user->user_name}}
        </label>
      </div>
      <form>
        <div class="form-group">
          <label for="exampleInputEmail1">Mobile Number</label>
          <input
          style="padding-left:77px;"
            type="text"
            class="form-control flag_input"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            value="{{$plate->user->country_code}}&nbsp;&nbsp;{{$plate->user->mobile_number}}"
            readonly='true'
            placeholder=" mobile number"
          />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Whatsapp Number</label>
          <input
          style="padding-left:77px;"
            type="text"
            class="form-control flag_input"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            value="{{$plate->whatsapp_country_code}}&nbsp;&nbsp;{{$plate->whatsapp_number}}"
            readonly='true'
            placeholder=" Whatsapp number"
          />
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Email Id</label>
          <input
            type="email"
            class="form-control"
            id="exampleInputPassword1"
            value="{{$plate->user->email}}"
            readonly='true'
            placeholder="Email"
          />
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">
            Registration Date:-
            <span class="ml-1" style="color: black; font-size: 13px">
            {{date('d-m-Y',strtotime($plate->user->created_at))}}
            </span>
          </label>
        </div>
      </form>
    </div>
          <!-- Modal -->
 <div class="modal fade" id="modalTC" role="dialog">
  <div class="modal-dialog">
   <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header" style="background-color: #FFB91D;">
      <h4 class="modal-title">User Detail</h4>
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
           </div>

            </div>
        </div>  
    </div>
    
    @endsection

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

    