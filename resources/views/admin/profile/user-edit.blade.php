@extends('layouts.app')
@section('content')
<style type="text/css">
    .col-lg-2.control-label.pull-right {
        margin-right: 248px;
        margin-top: -43px;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add form</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                        </ul>
                        <a class="close-link">
                                <i class="fa fa-times"></i>
                        </a> -->
                    </div>
                </div>

                <div class="ibox-content">
                    {{ Form::open( array('method' => 'post', 'class' => 'form-horizontal','files' => true, 'id' => 'updateProfile' )) }}
                    <div class="form-group">
                        <label class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-9">
                            {{ Form::text('firstname', $user[0]['firstname'], array('class' => 'form-control first_name' ,'required')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-9">
                            {{ Form::text('lastname', $user[0]['lastname'], array('class' => 'form-control first_name' ,'required')) }}
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-9">
                            {{ Form::text('email', $user[0]['email'], array('class' => 'form-control email' ,'readonly'=>'true')) }}
                        </div>
                    </div>
                    <!-- <div class="form-group">
                            <label class="col-lg-2 control-label">File</label>
                                    <div class="fileinput fileinput-new input-group col-lg-9" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="profile_pic"/>
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div> 
                    </div> -->
                    <div class="form-group">
                        <label class="col-lg-2 control-label">File</label>
                        <div class="col-lg-6 fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="profile_pic"/>
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div> 
                        @php
                        $filename= url('uploads/client/'.$user[0]['user_image']);
                        $file_headers = @get_headers($filename);
                        @endphp
                        @if($file_headers[0] == 'HTTP/1.1 200 OK')
                        <div class="col-lg-2 control-label pull-right"> 
                            <a href="{{ $filename }}" target="_blank" class="btn btn-sm btn-info" >View File</a>
                        </div>
                        @else
                        <div class="col-lg-2 control-label pull-right"> 
                            <a href="javascript:;" class="btn btn-sm btn-info" >View File</a>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-9">
                            <button class="btn btn-sm btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>	
    </div>
</div>

@endsection