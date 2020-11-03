@extends('layouts.app')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add Users</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
                                    {{ Form::open( array('method' => 'post', 'class' => 'form-horizontal','files' => true, 'id' => 'addUser' )) }}
                                        <div class="form-group"><label class="col-lg-2 control-label">First Name</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('firstname', null, array('class' => 'form-control name' ,'required')) }}
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-lg-2 control-label">Last Name</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('lastname', null, array('class' => 'form-control name' ,'required')) }}
                                            </div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-lg-2 control-label">Email</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('email', null, array('class' => 'form-control email' ,'required')) }}
                                            </div>
                                        </div>
                                    
                                        <div class="form-group"><label class="col-lg-2 control-label">Password</label>
                                            <div class="col-lg-9">
                                                    <input name="password" type="password"  class="form-control" required>
                                                    
                                            </div>
                                        </div>
                                    
                                       
                                        
                                        <div class="form-group"><label class="col-lg-2 control-label">Image</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" name="profileImage" type="file">
                                            </div>
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