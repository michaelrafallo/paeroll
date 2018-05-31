@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Edit Leave Request</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.leaves.manager.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Leave Requests
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->






<div class="row">

    <div class="col-md-8 col-sm-8 col-centered">
        
        @include('notification')

        <div class="portlet light bordered">

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" class="form-horizontal" method="post">

                    {{ csrf_field() }}
                    <input type="hidden" name="op" value="1">   

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label ">Employee Name <span class="required">*</span></label>
                            <div class="col-md-8">
                                <div class="rtip">
                                {!! Form::select('employee', ['' => 'Select Employee'] + $employees, Input::old('employee', $info->employee), ['class' => 'form-control select2 ']) !!}                                    
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('employee','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Leave Type <span class="required">*</span></label>
                            <div class="col-md-8">
                                <div class="rtip">
                                {{ Form::select('leave', ['' => 'Select Leave Type'] + $post->select_posts(['post_type' => 'leave']), Input::old('leave', $info->leave), ['class' => 'form-control select2']) }}
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('leave','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Date Requested <span class="required">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group daterange-picker input-daterange">
                                    <input type="text" class="form-control rtip" name="date_start" value="{{ Input::old('date_start', $info->date_start) }}" placeholder="Date Start">
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control rtip" name="date_end" value="{{ Input::old('date_end', $info->date_end) }}" placeholder="Date End"> 
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('date_start','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                {!! $errors->first('date_end','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Status <span class="required">*</span></label>
                            <div class="col-md-4">
                                <div class="rtip">
                                {{ Form::select('status', ['' => 'Select Status'] + leave_type(), Input::old('status', $info->post_status), ['class' => 'form-control select2']) }}
                                </div>
                                {!! $errors->first('status','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                            </div>
                        </div>    
                                             
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>

        
    </div>


</div>


@endsection


@section('top_style')
@stop

@section('bottom_style')
<link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('bottom_plugin_script') 
<script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@stop

@section('bottom_script')
@stop
