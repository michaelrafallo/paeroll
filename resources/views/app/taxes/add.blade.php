@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Add {{ $single }}</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.taxes.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All {{ $label }}
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->


@include('notification')



<div class="row">

    <div class="col-md-12">

        <div class="portlet light bordered">

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" class="form-horizontal" method="post">

                    {{ csrf_field() }}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Period <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                {{ Form::select('payroll_period', payroll_period(), Input::old('payroll_period'), ['class' => 'form-control'] ) }}
                                <!-- START error message -->
                                {!! $errors->first('name','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Column <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="number" class="form-control rtip" name="column" placeholder="0" value="{{ Input::old('column') }}" min="0">                                
                                <!-- START error message -->
                                {!! $errors->first('column','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{ $single }} Name <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control rtip" name="name" placeholder="{{ $single }} Name" value="{{ Input::old('name') }}">
                                <!-- START error message -->
                                {!! $errors->first('name','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{ $single }} Code <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control rtip" name="code" placeholder="{{ $single }} Code" value="{{ Input::old('code') }}">                                
                                <!-- START error message -->
                                {!! $errors->first('code','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Exemption <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <h5>Base Tax Amount</h5>
                                <input type="text" class="form-control rtip" name="exemption_amount" placeholder="0.00" value="{{ Input::old('exemption') }}" step="any">                  
                            </div>
                            <div class="col-md-2">
                                <h5>Percent (Over)</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control rtip percent" data-target=".exemption_rate" name="exemption_percent" placeholder="0" value="{{ Input::old('exemption_percent') }}" step="any">
                                    <span class="input-group-addon">%</span>
                                </div>
        
                                <!-- START error message -->
                                {!! $errors->first('exemption_percent','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                            <div class="col-md-2">
                                <h5>Rate (Over)</h5>
                                <input type="number" class="form-control rtip exemption_rate" name="exemption_rate" placeholder="0.00" value="{{ Input::old('exemption_rate') }}" step="any">                  
                                 <!-- START error message -->
                                {!! $errors->first('exemption_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Compensation Level (Excess) <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="text" class="form-control rtip" name="excess" placeholder="0.00" value="{{ Input::old('excess') }}">                                
                                <!-- START error message -->
                                {!! $errors->first('excess','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-6">

                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        <input type="radio" name="status" value="0" {{ checked(Input::old('status'), 0) }}> Zero Exemption
                                        <span></span>
                                    </label>    
                                    <label class="mt-radio">
                                        <input type="radio" name="status" value="single" {{ checked(Input::old('status'), 'single') }}> Single
                                        <span></span>
                                    </label>    
                                    <label class="mt-radio">
                                        <input type="radio" name="status" value="married" {{ checked(Input::old('status'), 'married') }}> Married
                                        <span></span>
                                    </label>            
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Number of dependent</label>
                            <div class="col-md-4">
                                {{ Form::select('dependent', [0 => 'None'] + range(0, 4), Input::old('dependent'), ['class' => 'form-control'] ) }}
                                <span class="help-inline">Number of qualified dependent child(ren)</span>
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
