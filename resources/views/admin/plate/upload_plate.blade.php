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
        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Upload Plate</h5>
            </div>
            <div class="card-body">
            <div class="container">
            <div class="container">
            <div class="container">
  <div class="row">
    <div class="col-md-6 mt-5">
      <div class="card" style="width: 25rem">
        <div class="card-body card-outline">
          <div class="row">
            <div class="col-md-4 ">
              <div class="left-text">
                <h1>Arabic Numbers</h1>
                <p>8 8 8 8</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="logo-area">
                <img src="{{asset('/assets/admin/images/logo.png')}}" class="logo" alt="" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="right-text">
                <h1>Arabic Alphabets</h1>
                <p>L T D</p>
              </div>
            </div>
          </div>
        </div>
        <form>
          <div class="form-group mt-5">
            <label for="exampleInputEmail1">User Name</label>
            <input
              type="email"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Enter name"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Email Id</label>
            <input
              type="password"
              class="form-control"
              id="exampleInputPassword1"
              placeholder="Enter email"
            />
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-6 mt-5">
      <form>
        <div class="form-group">
          <label for="exampleInputEmail1">Calling Number</label>
          <input
            type="email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            placeholder="Enter no"
          />
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Whatsapp Number</label>
          <input
            type="password"
            class="form-control"
            id="exampleInputPassword1"
            placeholder="Enter no"
          />
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Price</label>
          <div class="form-check mt-1">
            <input
              class="form-check-input"
              type="radio"
              name="flexRadioDefault"
              onclick="hide()"
              id="flexRadioDefault1"
            />
            <label class="form-check-label" for="flexRadioDefault1">
              No Fixed Price
            </label>
          </div>
          <div class="form-check mt-1">
            <input
              class="form-check-input"
              type="radio"
              name="flexRadioDefault"
              onclick="show()"
              id="flexRadioDefault1"
            />
            <label class="form-check-label" for="flexRadioDefault1">
              Fixed Price
            </label>
          </div>
          <input
            type="password"
            class="form-control mt-1"
            id="area"
            style="display: none;"
            placeholder="Enter Price"
          />
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
      </form>
    </div>
  </div>
</div>
  
</div>
           </div>

            </div>
        </div>  
    </div>
    

    <script type="text/javascript">
        function show() { document.getElementById('area').style.display = 'block'; }
        function hide() { document.getElementById('area').style.display = 'none'; }
      </script>
    @endsection

    

    