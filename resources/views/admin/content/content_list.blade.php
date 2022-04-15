@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Content Management</h1> 
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/dashboard')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i>  Content</li>
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
                <h5 class="card-title">Content</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @if($content)
                            @foreach($content as $k=>$contents)
                        <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$contents->name}}</td>
                                <td>
                                <a href=" <?= url('admin/edit-content/' . base64_encode($contents->id)); ?> " class="composemail"><i class="fa fa-edit"></i></a>
                               </td> 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
@endsection