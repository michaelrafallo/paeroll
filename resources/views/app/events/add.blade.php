@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Add Event</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.events.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Events
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

                    <div class="form-body">


                        <div class="form-group">
                            <label class="col-md-3 control-label">Event Name <span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control rtip" name="name" placeholder="Event Name" value="{{ Input::old('name') }}">
                                <!-- START error message -->
                                {!! $errors->first('name','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date <span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control datepicker rtip" name="date" placeholder="Date" value="{{ Input::old('date') }}">
                                <!-- START error message -->
                                {!! $errors->first('date','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Pay Type <span class="required">*</span></label>
                            <div class="col-md-9">
                                <div class="mt-radio-list">
                                    <label class="mt-radio mt-radio-outline">
                                        {{ Form::radio('pay_type', 'regular_pay', Input::old('pay_type', 'regular_pay')) }} Regular Pay
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline">
                                        {{ Form::radio('pay_type', 'double_pay', Input::old('pay_type')) }} Double Pay
                                        <span></span>
                                    </label>
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('pay_type','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        {{ Form::radio('allow_ot', 'YES', Input::old('allow_ot')) }}  Allow Overtime
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline">
                                         {{ Form::radio('allow_nd', 'YES', Input::old('allow_nd')) }} Allow Night Differencial
                                        <span></span>
                                    </label> 
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-8">
                                <textarea name="description" class="form-control" placeholder="Description" rows="4">{{ Input::old('description') }}</textarea>
                                <!-- START error message -->
                                {!! $errors->first('description','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                     
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
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
