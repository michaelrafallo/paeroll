@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
            <h1 class="page-title">Dashboard</h1>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->



<div class="row">

    <div class="col-md-7">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-body">
    <div id="container"></div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>    

    <div class="col-md-5">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">

        <div class="well">
            <div class="row">
                <div class="col-md-6">
                    <small class="uppercase">LAST PAYROLL<br>
                    <b><?php echo date('D - F d, Y', strtotime('+15 day')); ?></b></small>

                </div>
                <div class="col-md-6">
                    <small class="uppercase">NEXT PAYROLL<br>
                    <b><?php echo date('D - F d, Y', strtotime('+15 day')); ?></b>    
                    </small>
                </div>
            </div>
        </div>


            <div class="portlet-body">
                <div id="calendar"></div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>    

</div>
@endsection



@section('top_style')

@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script')
	<!-- FULLCALENDAR -->
	<link href="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
	<script src="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>

	<!-- HIGHCHARTS -->
	<script src="https://code.highcharts.com/highcharts.src.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
	<!-- optional -->
	<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
@stop

@section('bottom_script') 
<script>
jQuery(document).ready(function() {    
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var h = {};

    $('#calendar').fullCalendar({ 
        defaultView: 'month', 
        editable: false,
        droppable: false,
        events: [{
            title: 'HOLIDAY',
            start: '<?php echo date('Y-m-d', strtotime('-10 day')); ?>',
            end: '<?php echo date('Y-m-d', strtotime('-10 day')); ?>',
            backgroundColor: '#FF9800',
            borderColor: '#FF9800'
        }, {
            title: 'PAYROLL',
            start: '<?php echo date('Y-m-d', strtotime('-2 day')); ?>',
            end: '<?php echo date('Y-m-d'); ?>',
            backgroundColor: '#0023e6',
            borderColor: '#0023e6'
        }, {
            title: 'PAYDAY',
            start: '<?php echo date('Y-m-d'); ?>',
            end: '<?php echo date('Y-m-d'); ?>',
            backgroundColor: '#ff0000',
            borderColor: '#ff0000'
        }]
    });
});    


Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Payroll Sumarry'
    },
    subtitle: {
        text: 'Statistics Report for 2017'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Payroll Sumarry'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PHP</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Gross Payroll',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }, {
        name: 'Net Payroll',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

    }, {
        name: 'Tax',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

    }]
});
</script>
@stop
