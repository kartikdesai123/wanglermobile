@extends('layouts.app')
    @section('content')
       <div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			{{ csrf_field() }}
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Users</h5>
                        <div class="ibox-tools">
                        	<a href="{{ route('add-users')}}" class="btn btn-primary dim" ><i class="fa fa-plus"> Add User</i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    	<div class="table-responsive">
                    		<table class="table table-striped table-bordered table-hover dataTables-example" id="userList">
                    			<thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Profile Image</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                    			</thead>
                    			<tbody>
                    				
                    			</tbody>
                    			
                    		</table>
                    	</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
