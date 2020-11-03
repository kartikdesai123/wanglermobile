@extends('layouts.app')
    @section('content')
       <div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			{{ csrf_field() }}
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Customer List</h5>
                        <div class="ibox-tools">
                        	<a href="#" class="btn btn-primary dim updateCustomer" ><i class="fa fa-refresh"> Update Customer</i></a>
                          
                        </div>
                    </div>
                    <div class="ibox-content">
                    	<div class="table-responsive">
                    		<table class="table table-striped table-bordered table-hover dataTables-example" id="customerLIst">
                    			<thead>
                    				<tr>
                    					<th>No</th>
                    					<th>Title</th>
                    					<th>First Name</th>
                    					<th>Middle Name</th>
                    					<th>Last Name</th>
                                                        <th>Company Name</th>
                    					<th>Email</th>
                    					<th>Phone Number</th>
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
