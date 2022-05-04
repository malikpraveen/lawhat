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
                                       <div class="row mx-0 mb-2">
                
              
              
                  <div class="col-3 px-1">
                     <select class="form-select form-select_design" id="pname4"  name="pname3"  onchange="autofill3(4)" aria-label="Default select example">
                     <option selected></option>
                     <option >٠</option>
                        <option >١</option>
                        <option >٢</option>
                        <option >٣</option>
                        <option >٤</option>
                        <option >٥</option>
                        <option >٦</option>
                        <option >٧</option>
                        <option >٨</option>
                        <option >٩</option>
                     </select>
                  </div>
                  <div class="col-3 px-1">
                     <select class="form-select form-select_design" id="pname3"  name="pname2"  onchange="autofill3(3)" aria-label="Default select example">
                     <option selected></option>
                     <option >٠</option>
                        <option >١</option>
                        <option >٢</option>
                        <option >٣</option>
                        <option >٤</option>
                        <option >٥</option>
                        <option >٦</option>
                        <option >٧</option>
                        <option >٨</option>
                        <option >٩</option>
                     </select>
                  </div>
                  <div class="col-3 px-1">
                     <select class="form-select form-select_design" id="pname2"  name="pname1"  onchange="autofill3(2)" aria-label="Default select example">
                     <option selected></option>
                     <option >٠</option>
                        <option >١</option>
                        <option >٢</option>
                        <option >٣</option>
                        <option >٤</option>
                        <option >٥</option>
                        <option >٦</option>
                        <option >٧</option>
                        <option >٨</option>
                        <option >٩</option>
                     </select>
                  </div>
                  <div class="col-3 px-1">
                     <select class="form-select form-select_design" id="pname1" name="pname"  onchange="autofill3(1)" aria-label="Default select example">
                        <option selected></option>
                        <option >٠</option>
                        <option >١</option>
                        <option >٢</option>
                        <option >٣</option>
                        <option >٤</option>
                        <option >٥</option>
                        <option >٦</option>
                        <option >٧</option>
                        <option >٨</option>
                        <option >٩</option>
                     </select>
                  </div>
               </div>


               <div class="row mx-0 mb-2">
                  <div class="col-3 px-1">
                     <input class="form-control form_input_design" name ="plate_number_en" type="text" id='field1'>
                  </div>
                  <div class="col-3 px-1">
                     <input class="form-control form_input_design" name ="plate_number_en1"  type="text" id='field2'>
                  </div>
                  <div class="col-3 px-1">
                     <input class="form-control form_input_design" name ="plate_number_en2"  type="text" id='field3'>
                  </div>
                  <div class="col-3 px-1">
                     <input class="form-control form_input_design" name ="plate_number_en3"  type="text" id='field4'>
                  </div>
               </div>
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
                                       <div class="row mx-0 mb-2">
                
              
                  <div class="col px-1">
                     <select class="form-select form-select_design" id="pname8" name="pname6"   onchange="autofill4(8)" aria-label="Default select example">
                     <option selected></option>
                     <option >أ </option>
                        <option >ب</option>
                        <option >ح</option>
                        <option >د</option>
                        <option >ر</option>
                        <option >س </option>
                        <option >ص</option>
                        <option >ط </option>
                        <option >ع </option>
                        <option >ق </option>
                        <option >ك</option>
                        <option >ل </option>
                        <option >م </option>
                        <option >ن </option>
                        <option >هـ </option>
                        <option >و </option>
                        <option >ى </option>
                     </select>
                  </div>
                  <div class="col px-1">
                     <select class="form-select form-select_design" id="pname7"  name="pname5"  onchange="autofill4(7)" aria-label="Default select example">
                     <option selected></option>
                     <option >أ </option>
                        <option >ب</option>
                        <option >ح</option>
                        <option >د</option>
                        <option >ر</option>
                        <option >س </option>
                        <option >ص</option>
                        <option >ط </option>
                        <option >ع </option>
                        <option >ق </option>
                        <option >ك</option>
                        <option >ل </option>
                        <option >م </option>
                        <option >ن </option>
                        <option >هـ </option>
                        <option >و </option>
                        <option >ى </option>
                     </select>
                  </div>
                  <div class="col px-1">
                     <select class="form-select form-select_design" id="pname6" name="pname4"  onchange="autofill4(6)" aria-label="Default select example">
                        <option selected></option>
                        <option >أ </option>
                        <option >ب</option>
                        <option >ح</option>
                        <option >د</option>
                        <option >ر</option>
                        <option >س </option>
                        <option >ص</option>
                        <option >ط </option>
                        <option >ع </option>
                        <option >ق </option>
                        <option >ك</option>
                        <option >ل </option>
                        <option >م </option>
                        <option >ن </option>
                        <option >هـ </option>
                        <option >و </option>
                        <option >ى </option>

                     </select>
                  </div>
               </div>
               <div class="row mx-0 mb-2">
                  <div class="col px-1">
                     <input class="form-control form_input_design" name ="plate_alphabets_en" type="text" id='field6'>
                  </div>
                  <div class="col px-1">
                     <input class="form-control form_input_design" name ="plate_alphabets_en1" type="text" id='field7'>
                  </div>
                  <div class="col px-1">
                     <input class="form-control form_input_design" name ="plate_alphabets_en2" type="text" id='field8'>
                  </div>
                 
               </div>
               
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <p class="text-danger" id="numberError"></p>
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
                     <div className="d-flex">
                      <span class="input-group-addon">+966</span>
                     <input
                        type="text"
                        class="form-control flag_input validate"
                        maxlength = "9"
                        name ="calling_number"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Enter no"
                        />
                     <p class="text-danger" id="calling_numberError"></p>
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="exampleInputPassword1">Whatsapp Number</label>
                     <div className="d-flex">
                      <span class="input-group-addon">+966</span>
                     <input
                        type="text"
                        class="form-control flag_input validate"
                        maxlength = "9"
                        name ="whatsapp_number"
                        id="exampleInputPassword1"
                        placeholder="Enter no"
                        />
                        <p class="text-danger" id="whatsapp_numberError"></p>
                     </div>
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
   var formData = $("#addForm").find("select");
   $(formData).each(function () {
       var element = $(this);
       var val = element.val();
      
       if (val == "" || val == "0" || val == null) {
           
       $("#numberError").html("Plate Number is required field, All characters are required");
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

function autofill3(count){

var arr = {"0":"٠","1":"١","2":"٢","3":"٣","4":"٤","5":"٥","6":"٦","7":"٧","8":"٨","9":"٩"};
var inps = document.getElementById('pname'+ count).value;
for(var key in arr)
{
    if(arr[key]==inps)
         // console.log(key);
         document.getElementById('field'+count).value= key;
}
 



    }
</script>

<script>

function autofill4(count){
var arr = { "A": 'أ', "B": 'ب','J':'ح','D':'د','R':'ر','S':'س','X':'ص','T':'ط','E':'ع','G':'ق','K':'ك','L':'ل','Z':'م','N':'ن','H':'هـ','U':'و','V':'ى'};
var inps = document.getElementById('pname'+ count).value;
for(var key in arr)
{
    if(arr[key]==inps)
         // console.log(key);
         document.getElementById('field'+count).value= key;
}
 

// document.getElementById('field'+count).value= Object.keys(imageList[j]);


    }
</script>


@endsection