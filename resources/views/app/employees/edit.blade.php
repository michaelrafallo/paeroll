@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Edit Employee
            <a href="{{ URL::route('app.employees.add') }}" class="btn-xs"><i class="fa fa-plus"></i> Add New</a>
           </h1>
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
                <form action="{{ URL::route('app.employees.ajax.update') }}" class="form-horizontal form-save" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $info->id }}">   

                    <div class="row profile-account">
                        <div class="col-md-3">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail img-circle img-thumbnail img-responsive" data-trigger="fileinput" style="min-width: 150px; min-height: 150px;"> 
                                    <img src="{{ has_photo($info->profile_picture) }}">
                                </div>
                                <div>
                                    <span class="btn blue btn-outline btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="file" accept="image/*"> </span>
                                </div>
                            </div>

                            <label class="mt-checkbox">
                                <input type="checkbox" name="status" value="actived" {{ checked($info->status, 'actived') }}> Active Employee
                                <span></span>
                            </label>

                            <ul class="ver-inline-menu tabbable margin-top-20">
                                <li class="active">
                                    <a data-toggle="tab" href="#personal-data">
                                        <i class="fa fa-user"></i> Personal Data </a>
                                    <span class="after"> </span>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#educational-background">
                                        <i class="fa fa-graduation-cap"></i> Educational Background</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#organizational-assignment">
                                        <i class="fa fa-calendar-check-o"></i> Organizational Assignment</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#statutory-data">
                                        <i class="fa fa-folder-open-o"></i> Statutory Data</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#salary">
                                        <i class="fa fa-credit-card"></i> Salary</a>
                                </li>

                                @if( App\Setting::get_setting('leave_management') )
                                <li class="">
                                    <a data-toggle="tab" href="#leave">
                                        <i class="fa fa-plane"></i> Leave Balances </a>
                                </li>
                                @endif

                                <li class="">
                                    <a data-toggle="tab" href="#employment-data">
                                        <i class="fa fa-briefcase"></i> Employment Data</a>
                                </li>

                            </ul>


                        </div>
                        <div class="col-md-9">
                            <div class="tab-content load-details">
                                @include('app.employees.tabs.details')
                            </div>
                        </div>
                        <!--end col-md-9-->
                    </div>

                <button type="submit" class="hide"></button>        

                </form>
                <!-- END FORM-->
            </div>
        </div>


    </div>

</div>


<div class="form-actions-fixed">
    <button type="submit" class="btn btn-primary ajax-save" data-target=".form-save"><i class="fa fa-check"></i> Save Changes</button>        
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
<script>
var blockUImsg = 'Updating employee details ...';




</script>
@stop
