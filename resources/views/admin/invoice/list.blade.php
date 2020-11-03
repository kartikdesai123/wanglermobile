@extends('layouts.app')
    @section('content')
        <div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			{{ csrf_field() }}
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Invoice List</h5>
                        <div class="ibox-tools">
                        	<a  class="btn btn-danger  dim createInvoice" >Create Invoice</a>
                                <a  class="btn btn-primary dim updateInvoice" >Update Invoice</a>
                        </div>
                        <div class="ibox-tools">
                        	
                          
                        </div>
                    </div>
                    <div class="ibox-content">
                    	<div class="table-responsive">
                    		<table class="table table-striped table-bordered table-hover dataTables-example" id="invoiceList">
                    			<thead>
                    				<tr>
                    					<th>No</th>
                    					<th>Customer Name</th>
                    					<th>Customer Email</th>
                    					<th>Amount</th>
                    					<th>Type</th>
                    					<th>Discount</th>
                    					<th>Tax</th>
                                                        <th>Total</th>
                    					<th>Invoice Date</th>
                    					<th>Due Date</th>
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
