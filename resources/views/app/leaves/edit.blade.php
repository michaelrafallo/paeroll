@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Edit Leave
            <a href="{{ URL::route('app.leaves.add') }}" class="btn-xs"><i class="fa fa-plus"></i> Add New</a>
           </h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.leaves.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Leaves
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
                            <label class="col-md-3 control-label">Leave Name <span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control rtip" name="name" placeholder="Leave Name" value="{{ Input::old('name', $info->post_title) }}">
                                <!-- START error message -->
                                {!! $errors->first('name','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Code <span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control rtip" name="code" placeholder="Code" value="{{ Input::old('code', $info->post_name) }}">
                                <!-- START error message -->
                                {!! $errors->first('code','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Default Balance <span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control rtip" name="balance" placeholder="Default Balance" value="{{ Input::old('balance', $info->balance) }}" min="1">
                                <!-- START error message -->
                                {!! $errors->first('balance','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-8">
                                <textarea name="description" class="form-control" placeholder="Description" rows="4">{{ Input::old('description', $info->post_content) }}</textarea>
                                <!-- START error message -->
                                {!! $errors->first('description','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-8">
                            <label class="mt-checkbox">
                                <input type="checkbox" name="status" value="actived" {{ checked($info->post_status, 'actived') }}> Active
                                <span></span>
                            </label>
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
