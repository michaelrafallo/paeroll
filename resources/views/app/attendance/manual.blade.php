@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Manual Punch</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.attendance.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> Attendance
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
                <form action="" class="form-horizontal" method="post">

                    {{ csrf_field() }}
                    <input type="hidden" name="op" value="1">   

                    <div class="form-body row">
<?php 
function attendance_group() {

    $data = [
        '' => 'Choose One',
        '1' => 'All Employees',
        '2' => 'Departments',
        '3' => 'Positions',
        '4' => 'Employees'
    ];

    return $data;
}
?>
                        <div class="col-md-6">

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5>Manual Punch for :</h5>
                                    {{ Form::select('', attendance_group(), '', ['class' => 'form-control']) }}             
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">

                                 <h5>Search Departments :</h5>
                                 {{ Form::select('', [], '', ['class' => 'form-control select2', 'multiple']) }}    
                                       
      
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <div class="col-md-8">
                                    <h5>Date of Attendance <span class="required">*</span></h5>
                                    <input type="text" name="date_in" class="form-control datepicker input-sm rtip" placeholder="DD-MMM-YYYY">                
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <h5>Date IN <span class="required">*</span></h5>
                                    <input type="text" name="date_in" class="form-control datepicker input-sm rtip" placeholder="DD-MMM-YYYY">                
                                </div>
                                <div class="col-md-4">
                                    <h5>Time IN <span class="required">*</span></h5>
                                    <input type="text" name="date_in" class="form-control timepicker input-sm rtip" placeholder="00:00">                
                                </div>                    
                            </div>                    

                            <div class="form-group">
                                <div class="col-md-4">
                                    <h5>Date OUT <span class="required">*</span></h5>
                                    <input type="text" name="date_in" class="form-control datepicker input-sm rtip" placeholder="DD-MMM-YYYY">                
                                </div>          
                                <div class="col-md-4">                                
                                    <h5>Time OUT <span class="required">*</span></h5>
                                    <input type="text" name="date_in" class="form-control timepicker input-sm rtip" placeholder="00:00">                
                                </div>                   
                            </div>  

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5>Remarks</h5>
                                    <textarea class="form-control input-sm" rows="5" placeholder="Enter remarks here ..."></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Attendance</button>
                                    </div>
                                </div>
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


@stop

@section('bottom_plugin_script') 



@stop

@section('bottom_script')
@stop
