@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
<div class="content-header sty-one">
   <h1>Upload Plate</h1>
   <ol class="breadcrumb">
      <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
      <li><i class="fa fa-angle-right"></i> Plate </li>
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
   <div class="card mb-4">
      <div class="card-header mb-4">
         <h5 class="card-title">Upload Plate</h5>
      </div>
      <div class="card-body">
         <div class="container">
           <form method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/plate/submit')}}" >
           @csrf
            <div class="container">
               <div class="container">
                  <div class="row">
                     <div class="col-md-6 mt-5">
                        <div class="card" style="width: 25rem">
                              <div class="card-body card-outline">
                                 <div class="row mx-0 align-items-center">
                                    <div class="col px-2">
                                       <div class="form-group mb-0 my-2"> 
                                          <input type="text"  class="form-control border-0 shadow-none validate" name="plate_number_ar" id="exampleInputEmail1" aria-describedby="emailHelp"
                                             placeholder="Arabics Number"/>
                                          <input type="text"  class="form-control border-0 shadow-none validate" name="plate_number_en" id="exampleInputEmail1" aria-describedby="emailHelp"
                                             placeholder="888888"/>
                                       </div>
                                    </div>
                                    <div class="col-md-3 px-md-0">
                                       <div class="logo-area text-center">
                                          <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
                                          <label>Logo</label>
                                       </div>
                                    </div>
                                    <div class="col px-2">
                                       <div class="form-group mb-0 my-2"> 
                                          <input type="text"  class="form-control border-0 shadow-none validate" name="plate_alphabets_ar"   id="exampleInputEmail1" aria-describedby="emailHelp"
                                             placeholder="Arabics Number"/>
                                          <input type="text"  class="form-control border-0 shadow-none validate" name="plate_alphabets_en"  id="exampleInputEmail1" aria-describedby="emailHelp"
                                             placeholder="888888"/>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <p class="text-danger" id="plate_numberError"></p>
                              <div class="form-group mt-5">
                                 <label for="exampleInputEmail1">User Name</label>
                                 <input
                                    type="text"
                                    class="form-control validate" 
                                    name="name" 
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="Enter name"
                                    />
                                 <p class="text-danger" id="nameError"></p>
                              </div>
                              <div class="form-group">
                                 <label for="exampleInputPassword1">Email Id</label>
                                 <input
                                    type="email"
                                    name="email" 
                                    class="form-control validate"
                                    id="exampleInputPassword1"
                                    placeholder="Enter email"
                                    />
                                 <p class="text-danger" id="emailError"></p>
                              </div>
                        </div>
                     </div>
                     <div class="col-md-6 mt-5">
                    
                     <div class="form-group">
                     <label for="exampleInputEmail1">Calling Number</label>
                     <input
                        type="text"
                        class="form-control validate"
                        name ="calling_number"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Enter no"
                        />
                     <p class="text-danger" id="calling_numberError"></p>
                     </div>
                     <div class="form-group">
                     <label for="exampleInputPassword1">Whatsapp Number</label>
                     <input
                        type="text"
                        class="form-control validate"
                        name ="whatsapp_number"
                        id="exampleInputPassword1"
                        placeholder="Enter no"
                        />
                        <p class="text-danger" id="whatsapp_numberError"></p>
                     </div>
                     <div class="form-group">
                     <label for="exampleInputPassword1">Price</label>
                     <div class="form-check mt-1">
                     <input
                        class="form-check-input validate"
                        type="radio"
                        name="type"
                        value="noFixed"
                        id="flexRadioDefault1"
                        />
                     <label class="form-check-label" >
                     No Fixed Price
                     </label>
                     </div>
                     <div class="form-check mt-1">
                     <input
                        class="form-check-input validate"
                        type="radio"
                        name="type"
                        value="fixed"
                        id="flexRadioDefault1"
                        />
                     <label class="form-check-label" >
                     Fixed Price
                     </label>
                     </div>
                     <input
                        type="text"
                        class="form-control mt-1 validate"
                        id="area"
                        name="price"
                        placeholder="Enter Price"
                        />
                        <p class="text-danger" id="priceError"></p>
                     </div>
                     <button type="button" onclick="validate(this);" class="btn btn-primary">Submit</button>
                   
                     </div>
                  </div>
                 
               </div>
            </div>
          </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function show() { document.getElementById('area').style.display = 'block'; }
   function hide() { document.getElementById('area').style.display = 'none'; }
</script>
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
@endsection