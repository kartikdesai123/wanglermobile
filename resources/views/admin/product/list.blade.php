@extends('layouts.app')
    @section('content')
        <div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			{{ csrf_field() }}
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Product List</h5>
                        <div class="ibox-tools">
                        	<a  class="btn btn-primary dim updateProductList" ><i class="fa fa-refresh"> Update Product List</i></a>
                          
                        </div>
                    </div>
                    <div class="ibox-content">
                    	<div class="table-responsive">
                    		<table class="table table-striped table-bordered table-hover dataTables-example" id="productLIst">
                    			<thead>
                    				<tr>
                    					<th>No</th>
                    					<th>Product Name</th>
                    					<th>Product SKU</th>
                    					<th>Product Category</th>
                    					<th>Product Type</th>
                                                        <th>Product Quantity</th>
                    					<th>Product Price</th>
                    					<th>Product Description</th>
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
