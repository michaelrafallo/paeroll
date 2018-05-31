@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Edit {{ $single }}
           <a href="{{ URL::route('app.earnings.add', ['post_type' => $type]) }}" class="btn-xs"><i class="fa fa-plus"></i> Add New</a>
           </h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.earnings.index', ['post_type' => $type]) }}" class="btn btn-default margin-top-20"> 
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
                    <input type="hidden" name="op" value="1">   

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{ $single }} Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control rtip" name="name" placeholder="{{ $single }} Name" value="{{ $info->post_title }}">
                                <!-- START error message -->
                                {!! $errors->first('name','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                <!-- END error message -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-3">
                                <h5>{{ $single }} Code <span class="text-danger">*</span></h5>
                                <input type="text" class="form-control" name="code" placeholder="{{ $single }} Code" value="{{ $info->post_name }}">                                
                                <!-- START error message -->
                                {!! $errors->first('code','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                                <!-- END error message -->
                            </div>
                            <div class="col-md-4">
                                <h5>Multiplier <span class="text-danger">*</span></h5>
                                <div class="input-group">
                                    <span class="input-group-addon">x</span>
                                    <input type="text" class="form-control rtip" name="multiplier" placeholder="0.00" value="{{ $info->post_content }}">
                                </div>
                                <!-- START error message -->
                                {!! $errors->first('multiplier','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
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
