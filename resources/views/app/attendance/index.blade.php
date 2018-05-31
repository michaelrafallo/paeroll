@extends('layouts.app')

@section('content')

@include('notification')



<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Attendance</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">

        </div>
    </div>
</div>
<!-- END PAGE BAR -->


<div class="portlet light bordered">
    @include('app.attendance.search')

    <div class="table-responsive">
    <table class="table table-hover table-stripedx table-bordered">
        <thead>
            <tr>
                <th>Details</th>
                <th></th>
                <th class="am"> Time In</th>
                <th class="pm"> Time Out</th>

                <th>Total Hours</th>
                <th>Remarks</th>


            </tr>
        </thead>
        <tbody>
            @foreach(range(1, 10) as $row)
            <tr>
                <td width="1">
                    <img src="{{ asset('img/avatar.png') }}" class="img-responsive img-thumb"> 
                </td>
                <td>
                    <h4 class="no-margin"><a href="">Juan Dela Cruz</a></h4>
                    
                    <small class="">Fulltime - Web Developer</small><br>
                    <small class=" text-muted">Information Technology</small>
                </td>
                <td class="edit-attendance am">

                     08-Sep-2017<br>
                    <span class="text-danger"><b>08:10 AM</b></span>
                </td>

                <td class="edit-attendance pm">
                    08-Sep-2017<br>
                    <b>05:40 AM</b>
                </td>
                <td>8H 30M</td>
                <td class="edit-attendance">
                    <i class="fa fa-calendar-check-o tooltips"  
                    data-placement="left" 
                    data-original-title="Regular Holiday"></i> Regular Holiday<br>
                    30M Late
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</div>


<div class="modal fade attendance-modal" id="popupModal"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h4>Attendance</h4>
        </div>
        <div class="modal-body">
            
            <form method="post" class="form-horizontal">

                <div class="form-body">

                    <div class="form-group">
                        <div class="col-md-3">
                            <img src="{{ asset('img/avatar.png') }}" class="img-circle img-thumbnail img-responsive">                
                        </div>
                        <div class="col-md-9">

                            <h2><a href="">Michael Rafallo</a></h2>

                            <div class="row">
                                <div class="col-md-7">
                                <h5 class="no-margin">Fulltime - Web Developer</h5>
                                <span class="text-muted">Information Technology</span>
                                </div>

                                <div class="col-md-5">
                                    <h5 class="no-margin text-muted">Shift :</h5>  8:00 AM - 5:00 PM                           
                                </div>                                
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <h5>Date In</h5>
                            <input type="text" name="date_in" class="form-control datepicker input-sm" placeholder="DD-MMM-YYYY">                
                        </div>
                        <div class="col-md-6">
                            <h5>Time In</h5>
                            <input type="text" name="date_in" class="form-control input-sm timepicker" placeholder="00:00">                
                        </div>                
                    </div>                    

                    <div class="form-group">
                        <div class="col-md-6">
                            <h5>Date Out</h5>
                            <input type="text" name="date_in" class="form-control datepicker input-sm" placeholder="DD-MMM-YYYY">                
                        </div>
                        <div class="col-md-6">
                            <h5>Time Out</h5>
                            <input type="text" name="date_in" class="form-control input-sm timepicker" placeholder="00:00">                
                        </div>                
                    </div>  

                    <div class="form-group">
                        <div class="col-md-12">
                            <h5>Remarks</h5>
                            <textarea class="form-control input-sm" rows="5" placeholder="Enter remarks here ..."></textarea>
                        </div>
                    </div>

                </div>
            
            </form>


        </div>

        <div class="modal-footer">
        <a class="btn btn-primary confirm uppercase" data-href="#" data-index="" data-id="" data-target=""><i class="fa fa-check"></i> Confirm</a>
        <button class="btn btn-default uppercase" aria-hidden="true" data-dismiss="modal" class="close" type="button">Close</button> 
        <span class="msg"></span>           
        </div>
       
    </div>
  </div>
</div>
@endsection


@section('top_style')
<style>
.edit-attendance {
    cursor: pointer;
}    
.table-hover>tbody>tr>td:hover.edit-attendance {
    background: #fff493!important;
}
.am {
     background: #f7f7f7!important;   
}
.pm {
     background: #efefef!important;   
}

</style>
@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
<script>
$(document).on('click','.edit-attendance', function() {
    $('.attendance-modal').modal('show');
});    
</script>
@stop
