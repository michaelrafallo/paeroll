@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
            <h1 class="page-title">General Settings</h1>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->


<div class="row">

    <div class="col-md-12">

        @include('notification')

        <div class="portlet light bordered">
            <div class="portlet-body form row">
                <form class="form-horizontal form-save" action="" role="form" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="op" value="1">   

                    <div class="col-md-3">

                        <ul class="ver-inline-menu tabbable margin-top-20 navigation-tab">
                            <li class="active">
                                <a data-toggle="tab" href="#system">
                                    <i class="fa fa-gears"></i> System</a>
                                <span class="after"> </span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#payroll">
                                    <i class="fa fa-calculator"></i> Payroll</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#reports">
                                    <i class="fa fa-pie-chart"></i> Reports</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#leave">
                                    <i class="fa fa-plane"></i> Leave Management</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#attendance">
                                    <i class="fa fa-clock-o"></i> Attendance Tracker</a>
                            </li>
                        </ul>

                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">

                            @include('app.general.settings.details')

                        </div>
                    </div>

                    <button type="submit" class="hide"></button>        

                </form>
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
<script>
var blockUImsg = 'Updating general settings ...';

$(".form-save").on('submit', function(e) {
    e.preventDefault();

    var formData = $(this),
        url      = formData.attr('action'),
        tab      = $(this).find('li.active a').attr('href');

    blockUI(blockUImsg);

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method 
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(response)   // A function to be called if request succeeds
        {
            var IS_JSON = true;
            try {
                var data = JSON.parse(response);
            } catch(err){
                IS_JSON = false;
            } 

            if( IS_JSON ) {
                $.each(data.details, function(key, val) {
                    $('#'+key).html('<span class="text-danger help-inline">'+val+'</div>');
                });
            } else {
                $('.load-details').html( response );
                $('.tab-pane').removeClass('active');
                $(tab).addClass('active');
                init_repeater();
                app_init();
                initTable();
                $.unblockUI();  

                $('.menu-attendance').addClass('hide');
                $('.menu-leave').addClass('hide');

                if( $('[name="attendance"]:checked').val() == 1 ) {
                    $('.menu-attendance').removeClass('hide');
                }
                if( $('[name="leave_management"]:checked').val() == 1 ) {
                    $('.menu-leave').removeClass('hide');
                }

                $('.page-footer-inner span').html($('[name="copy_right"]').val());

                var src = $('.setting-logo img').attr('src');
                $('.logo-default').attr('src', src);
            }

        }
    });
});

</script>

@stop
