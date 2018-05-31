@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Add Employee</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.employees.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Employees
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->


@include('notification')



<div class="row">

    <div class="col-md-12 col-centered">

        <div class="portlet light bordered">

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" class="form-horizontal form-submit" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <input type="hidden" name="op" value="1">   

                    <div class="form-body row">

                        <div class="col-md-3">
                     
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail img-circle img-thumbnail img-responsive" data-trigger="fileinput" style="min-width: 150px; min-height: 150px;"> 
                                            <img src="{{ asset('img/avatar.png') }}">
                                        </div>
                                        <div>
                                            <span class="btn blue btn-outline btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="file"> </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-9">

                            <h4 class="uppercase">Personal Data</h4>

                            <div class="form-group">
                                <div class="col-md-4">
                                <h5 class="text-muted">First Name <span class="required">*</span></h5>
                                    <input type="text" class="form-control rtip" name="firstname" placeholder="First Name" value="{{ Input::old('firstname') }}">
                                    <!-- START error message -->
                                    {!! $errors->first('firstname','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Middle Name</h5>
                                    <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="{{ Input::old('middlename') }}">
                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Last Name <span class="required">*</span></h5>
                                    <input type="text" class="form-control rtip" name="lastname" placeholder="Last Name" value="{{ Input::old('lastname') }}">
                                    <!-- START error message -->
                                    {!! $errors->first('lastname','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <h5 class="text-muted">Gender <span class="required">*</span></h5>
                                    <div class="rtip">
                                    {{ Form::select('gender', ['' => 'Select Gender'] + genders(), Input::old('gender'), ['class' => 'form-control select2'] )  }}
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('gender','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>
                                
                                <div class="col-md-4">
                                    <h5 class="text-muted">Birth Date <small class="text-muted uppercase">( mm-dd-yyyy )</small> <span class="required">*</span></h5>
                                    <input type="text" class="form-control datepicker rtip" name="birth_date" placeholder="Birth Date" value="{{ Input::old('birth_date') }}">
                                    <!-- START error message -->
                                    {!! $errors->first('birth_date','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->

                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Civil Status <span class="required">*</span></h5>
                                    <div class="rtip">
                                    {{ Form::select('civil_status', ['' => 'Select Civil Status'] + civil_status(), Input::old('civil_status'), ['class' => 'form-control select2'] )  }}
                                    </div>
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('civil_status','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>

                            <hr>
                            <h4 class="uppercase">Organizational Assignment</h4>

                            <div class="form-group">
    
                                <div class="col-md-4">
                                    <h5 class="text-muted">Department <span class="required">*</span></h5>
                                    <div class="rtip">
                                    {{ Form::select('department', ['' => 'Select Department'] + $post->select_posts(['post_type' => 'department']), Input::old('department'), ['class' => 'form-control select2'] )  }}
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('department','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Position <span class="required">*</span></h5>
                                    <div class="rtip">
                                    {{ Form::select('position', ['' => 'Select Position'] + $post->select_posts(['post_type' => 'position']), Input::old('position'), ['class' => 'form-control select2'] )  }}
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('position','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-muted">Job Type <span class="required">*</span></h5>
                                    <div class="rtip">
                                    {{ Form::select('job_type', ['' => 'Select Job Type'] + $post->select_posts(['post_type' => 'job-type']), Input::old('job_type'), ['class' => 'form-control select2'] )  }}
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('job_type','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>
                            </div>


                            <hr>
                            <h4 class="uppercase">Salary</h4>


                            <div class="form-group">
                                <div class="col-md-4">
                                    <h5 class="text-muted">Monthly Rate <span class="required">*</span></h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control rtip" name="monthly_rate" placeholder="Monthly Rate" value="{{ Input::old('monthly_rate') }}">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-outline blue rate" data-target="monthly_rate"><i class="fa fa-calculator"></i></button>
                                        </div>
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('monthly_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Daily Rate <span class="required">*</span></h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control rtip" name="daily_rate" placeholder="Daily Rate" value="{{ Input::old('daily_rate') }}">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-outline blue rate" data-target="daily_rate"><i class="fa fa-calculator"></i></button>
                                        </div>
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('daily_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>

                                <div class="col-md-4">
                                    <h5 class="text-muted">Hourly Rate <span class="required">*</span></h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control rtip" name="hourly_rate" placeholder="Hourly Rate" value="{{ Input::old('hourly_rate') }}">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-outline blue rate" data-target="hourly_rate"><i class="fa fa-calculator"></i></button>
                                        </div>
                                    </div>
                                    <!-- START error message -->
                                    {!! $errors->first('hourly_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                    <!-- END error message -->
                                </div>
                            </div>



                            <hr>
                            <h4 class="uppercase">Statutory Data</h4>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5 class="text-muted">Spouse</h5>
                                    <input type="text" class="form-control" name="spouse" placeholder="Spouse" value="{{ Input::old('spouse') }}">
                                </div>
                            </div>

                            <h5 class="text-muted">Dependents</h5>

                            <div class="mt-repeater">
                                <div data-repeater-list="dependents">
                                    @if( $dependents = Input::old('dependents') )
                                    @foreach($dependents as $dependent)
                                    <div data-repeater-item="" class="mt-repeater-item">
                                        <div class="row mt-repeater-row">
                                            <div class="col-md-7">
                                                <h5>Name</h5>
                                                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $dependent['name'] }}">
                                            </div>
                                            <div class="col-md-3">
                                                <h5>Date of birth</h5>
                                                <input type="text" class="form-control datepicker" name="birthday" placeholder="MM-DD-YYYY" value="{{ $dependent['birthday'] }}">
                                            </div>
                                            <div class="col-md-1 margin-top-10">
                                                <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                                                    <i class="fa fa-close"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach  
                                    @else
                                    <div data-repeater-item="" class="mt-repeater-item">
                                        <div class="row mt-repeater-row">
                                            <div class="col-md-7">
                                                <h5>Name</h5>
                                                <input type="text" class="form-control" name="name" placeholder="Name" value="">
                                            </div>
                                            <div class="col-md-3">
                                                <h5>Date of birth</h5>
                                                <input type="text" class="form-control datepicker" name="birthday" placeholder="MM-DD-YYYY" value="">
                                            </div>
                                            <div class="col-md-1 margin-top-10">
                                                <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                                                    <i class="fa fa-close"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>                                    
                                    @endif
                                    
                                </div>
                                <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add margin-top-20">
                                    <i class="fa fa-plus"></i> Add Dependent</button>
                            </div>


                        </div>


                                             
                    </div>

                    <button type="submit" class="hide"></button>   

                </form>
                <!-- END FORM-->
            </div>
        </div>

        
    </div>


</div>



<div class="form-actions-fixed">
    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check"></i> Save</button>        
</div>

@endsection


@section('top_style')
<style> 
.form-actions-fixed {
    padding: 10px 20px;
    margin: 0 0 0 -20px;
}
</style>
@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
@stop
