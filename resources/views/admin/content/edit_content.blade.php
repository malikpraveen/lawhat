@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Content</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Content</li>
        </ol>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
        <div class="card">
            <form method='post' id="addForm" enctype="multipart/form-data" action="{{url('admin/content/update',[base64_encode($edit_content->id)])}}">
                @csrf
                <div class="card-body">   
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">{{$edit_content->name}}</label>
                                <textarea class="form-control validate" name="contenten" cols="6" rows="6" placeholder="add description_en">{{$edit_content->description_en}}</textarea>
                                <p class="text-danger" id="contentenError"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">{{$edit_content->name}}</label>
                                <textarea class="form-control validate" name="contentar" cols="6" rows="6" placeholder="add description_ar">{{$edit_content->description_ar}}</textarea>
                                <p class="text-danger" id="contentarError"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12"> 
                        <button type="button" class="mybtns pull-right" onclick="validate(this);" class="btn btn-primary">Save Content</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

    
    