@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">File a Leave</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.leaves.manager.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Leaves
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->






<div class="row">

    <div class="col-md-12 col-centered">
        
        @include('notification')

        <div class="portlet light bordered">

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" class="form-horizontal form-submit" method="post">

                    {{ csrf_field() }} 

                    <div class="form-body">

                        <div class="mt-repeater">
                            <div data-repeater-list="requests">


                                <div data-repeater-item="" class="mt-repeater-item">
                                    <div class="row mt-repeater-row">
                                        <div class="col-md-4">
                                            <h5>Employee Name</h5>
                                                {!! Form::select('employee', ['' => 'Select Employee'] + $employees, Input::old('leave'), ['class' => 'form-control select2']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Leave Type</h5>
                                                {{ Form::select('leave', ['' => 'Select Leave Type'] + $post->select_posts(['post_type' => 'leave']), Input::old('leave'), ['class' => 'form-control select2']) }}
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Date Requested</h5>
                                            <div class="input-group daterange-picker input-daterange">
                                                <input type="text" class="form-control" name="date_start" value="{{ Input::old('date_start') }}" placeholder="Date Start">
                                                <span class="input-group-addon"> to </span>
                                                <input type="text" class="form-control" name="date_end" value="{{ Input::old('date_end') }}" placeholder="Date End"> 
                                            </div>
                                        </div>

                                        <div class="col-md-1 visible-lg visible-sm">
                                        <a href="#" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete mt-delete">
                                            <i class="fa fa-close"></i>
                                        </a>                                                                                  
                                        </div>

                                        <div class="col-md-1 visible-sm visible-xs">
                                        <a href="#" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete btn-block btn-sm">
                                            <i class="fa fa-close"></i> Delete
                                        </a>      
                                        </div>

                                    </div>
                                </div>  


                            </div>

                            <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add margin-top-20">
                                <i class="fa fa-plus"></i> Add Request</button>

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
    <button type="submit" class="btn btn-primary btn-submit" data-target=".form-save"><i class="fa fa-check"></i> Save Changes</button>        
</div>
@endsection


@section('top_style')
<style>
.form-actions-fixed {
    padding: 10px 20px;
    margin: 0 0 0 -20px;
}

.mt-delete {    
    margin: 34px -25px 0!important;    
}
</style>
@stop

@section('bottom_style')
<link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('bottom_plugin_script') 
<script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@stop

@section('bottom_script')

@stop
