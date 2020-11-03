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
                                    {{ Form::open( array('method' => 'post', 'class' => 'form-horizontal','files' => true, 'id' => 'editUser' )) }}
                                        <div class="form-group hidden"><label class="col-lg-2 control-label">Name</label>
                                            <div class="col-lg-9 ">
                                                    {{ Form::text('id', $editDetails[0]->id , array('class' => 'form-control name' ,'required')) }}
                                                    {{ Form::text('oldImage', $editDetails[0]->user_image , array('class' => 'form-control name' ,'required')) }}
                                            </div>
                                        </div>
                                    
                                        <div class="form-group"><label class="col-lg-2 control-label">Name</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('firstname', $editDetails[0]->firstname , array('class' => 'form-control name' ,'required')) }}
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-lg-2 control-label">Name</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('lastname', $editDetails[0]->lastname , array('class' => 'form-control name' ,'required')) }}
                                            </div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-lg-2 control-label">Email</label>
                                            <div class="col-lg-9">
                                                    {{ Form::text('email', $editDetails[0]->email , array('class' => 'form-control email' ,'required')) }}
                                            </div>
                                        </div>
                                    
                                        
                                        
                                        <div class="form-group"><label class="col-lg-2 control-label">Profile Image</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" name="profileImage" type="file">
                                            </div>
                                        </div>
                                    
                                        @if( $editDetails[0]->profileimage != null || $editDetails[0]->profileimage != '')
                                            <div class="form-group"><label class="col-lg-2 control-label">&nbsp;</label>
                                                <div class="col-lg-9">
                                                    <a href="{{ asset("uploads/users/".$editDetails[0]->profileimage) }}" download>{{ $editDetails[0]->profileimage }}</a>
                                                </div>
                                            </div>
                                        @endif
                                        
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