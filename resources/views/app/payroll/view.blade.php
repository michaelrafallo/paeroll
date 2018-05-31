@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">View Employee <small>Pay Period : {{ $pay_from }} <i class="fa fa-long-arrow-right"></i> {{ $pay_to }} 
           | <span class="text-danger">Cutoff Date : {{ $cutoff }}</span></small></h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.payroll.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> Payroll
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
                <form action="" class="form-horizontal form-submit" method="post">

                    {{ csrf_field() }}

                    <?php $total = json_decode(@$payroll->total); ?>

                    <input type="hidden" name="fullname" value="{{ $info->fullname }}">
                    <input type="hidden" name="employee_id" value="{{ $info->employee_id }}">
                    <input type="hidden" name="job_type" value="{{ $post->find($info->job_type)->post_title }}">
                    <input type="hidden" name="position" value="{{ $post->find($info->position)->post_title }}">
                    <input type="hidden" name="department" value="{{ @$post->find($info->department)->post_name }}">

                    <input type="hidden" name="civil_status" value="{{ $info->civil_status }}">
                    <input type="hidden" name="tax_code" value="{{ $info->tax_code }}">

                    <input type="hidden" name="total[basic_pay]" value="{{ $total_basic_pay = @$total->basic_pay }}">
                    <input type="hidden" name="total[earnings]" value="{{ $total_earnings = @$total->earnings }}">
                    <input type="hidden" name="total[earnings_deductions]" value="{{ $earnings_deductions = @$total->earnings_deductions }}">
                    <input type="hidden" name="total[deductions]" value="{{ $total_deductions = @$total->deductions }}">
                    
                    <input type="hidden" name="total[ytd_gross_income]" value="{{ @$total->ytd_gross_income }}">
                    <input type="hidden" name="total[ytd_tax_withheld]" value="{{ @$total->ytd_tax_withheld }}">

                    <input type="hidden" name="total[gross_pay]" value="{{ $gross_pay = @$total->gross_pay }}" class="nan-zero">
                    <input type="hidden" name="total[gov_deductions]" value="{{ $gov_deductions = @$total->gov_deductions }}" class="nan-zero">
                    <input type="hidden" name="total[tax_withheld]" value="{{ $tax_withheld = @$total->tax_withheld }}" class="nan-zero">

                    <input type="hidden" name="total[net_pay]" value="{{ $net_pay = @$total->net_pay }}" class="nan-zero">


                    <div class="form-body row">

                        <div class="col-md-2">
                     
                            <div class="form-group">
                                <div class="col-md-12">
                                   <img src="{{ has_photo($info->profile_picture) }}" class="img-thumbnail">   
                                </div>
                            </div>



                        </div>

                        <div class="col-md-10">

                            <div class="row bg-profile">
                                <div class="col-md-3">
                                    <h4 class="sbold"><a href="{{ URL::route('app.employees.edit', $info->id) }}" target="_blank">{{ $info->fullname }}</a></h4>
                                    <div class="text-muted margin-top-10 icon-box">{{ $post->find($info->job_type)->post_title }} - {{ $post->find($info->position)->post_title }}</div>
                                </div>
                                <div class="col-md-3">
                                    <i class="icon icon-user pull-left"></i>
                                    <b class="text-muted">Employee No.</b><br>
                                    <h4 class="no-margin icon-box"> {{ $info->employee_id }}</h4>
                                </div>
                                <div class="col-md-3">
                                    <i class="icon icon-briefcase pull-left"></i>
                                    <b class="text-muted">Department</b><br>
                                    <span class="uppercase icon-box"> {{ @$post->find($info->department)->post_title }}</span>
                                </div>
                                <div class="col-md-3">
                                    <i class="icon icon-pin pull-left"></i>
                                    <b class="text-muted">Payroll Status</b>

                                    <span class="icon-box">
                                    @if( @$payroll->post_status )
                                    {{ status_ico($payroll->post_status) }}
                                    @else
                                    {{ status_ico('unprocessed') }}
                                    @endif
                                    </span>

                                </div>
                            </div>
                            


                            <div class="row margin-top-10 bg-profile">

                                <input type="hidden" name="monthly_rate" value="{{ $info->monthly_rate }}">
                                <input type="hidden" name="daily_rate" value="{{ $info->daily_rate }}">
                                <input type="hidden" name="hourly_rate" value="{{ $info->hourly_rate }}">

                
                                <div class="col-md-3">
                                    <i class="icon icon-shield pull-left"></i>
                                    <b class="text-muted">Tax Status</b><br>
                                    <span class="icon-box">{{ $info->tax_name }} <br> ( <span class="tax-code">{{ $info->tax_code }}</span> )</span>
                                </div>
                                <div class="col-md-3">
                                    <i class="icon icon-calendar pull-left"></i>
                                    <b class="text-muted">Monthly Rate</b>
                                    <h4 class="icon-box">{{ amount_formatted($info->monthly_rate) }}</h4> 
                                </div>

                                <div class="col-md-3">
                                    <i class="icon icon-calendar pull-left"></i>
                                    <b class="text-muted">Daily Rate</b>
                                    <h4 class="icon-box">{{ amount_formatted($info->daily_rate) }}</h4> 
                                </div>

                                <div class="col-md-3">
                                    <i class="icon icon-clock pull-left"></i>
                                    <b class="text-muted">Hourly Rate</b>
                                    <h4 class="icon-box">{{ amount_formatted($info->hourly_rate) }}</h4> 
                                </div>                                    


                            </div>


                        </div>


                        <div class="clearfix"></div>

                        <!-- START EARNINGS -->
                        <div class="col-md-7 margin-top-20">
                            <div class="portlet light bordered">

                                <h4 class="text-primary">Earnings</h4>
                                @include('app.payroll.temp.deductions')

                                @include('app.payroll.temp.holiday')
                                @include('app.payroll.temp.overtime')
                                @include('app.payroll.temp.night')
                                @include('app.payroll.temp.allowance')

                            </div>

                            <div class="portlet light bordered">
                                <h4 class="text-primary">Other Earnings</h4>

                                <input type="hidden" name="add_earnings[0][item]" value="">
                                <input type="hidden" name="add_earnings[0][amount]" value="">

                                <div class="mt-repeater">
                                    <div data-repeater-list="add_earnings">

                                        <?php $earnings = $post->select_posts(['post_type' => 'earning'], [], []); ?>

                                        @if(@$payroll->add_earnings)
                                        @foreach( json_decode($payroll->add_earnings) as $ae )
                                        <div data-repeater-item="" class="mt-repeater-item">
                                            <div class="row mt-repeater-row">

                                                <div class="col-md-7 input-group-sm">
                                                    {{ Form::select('item', ['' => 'Select Item'] + $earnings, $ae->item, ['class' => 'form-control select2']) }}
                                                    <input type="hidden" name="name" class="item-name" value="{{ @$ae->name }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">P</span>
                                                        <input type="text" class="numeric form-control text-right input-sm oe sum" name="amount" placeholder="0.00" value="{{ @$ae->amount }}" maxlength="12">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                     <a data-repeater-delete="" class="btn btn-default mt-repeater-delete btn-sm">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div data-repeater-item="" class="mt-repeater-item">
                                            <div class="row mt-repeater-row">

                                                <div class="col-md-7 input-group-sm">
                                                    {{ Form::select('item', ['' => 'Select Item'] + $earnings, '', ['class' => 'form-control select2']) }}
                                                    <input type="hidden" name="name" class="item-name" value="">
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">P</span>
                                                        <input type="text" class="numeric form-control text-right input-sm oe sum" name="amount" placeholder="0.00" value="" maxlength="12">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                     <a data-repeater-delete="" class="btn btn-default mt-repeater-delete btn-sm">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add btn-xs margin-top-10">
                                        <i class="fa fa-plus"></i> Add Earnings
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!-- END EARNINGS -->
                                      

                        <!-- START DEDUCTIONS -->
                        <div class="col-md-5 margin-top-20">

                        <div class="portlet light bordered">

                                <h4 class="text-danger">Government Deductions</h4>

                                <table class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th width="100">Amount</th>
                                    </tr>                                        
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $deductions = $post->where('post_type', 'government-deduction')
                                                           ->search(['tax_table' => '0'], [], ['tax_table'])
                                                           ->where('post_status', 'actived')
                                                           ->orderBy('post_title', 'ASC')
                                                           ->get();
                                        ?>

                                        <?php $govd = json_decode(@$payroll->deductions); ?>
                                        @foreach($deductions as $deduction)
                                        <?php $govd_id = $deduction->id; ?>
                                        <input type="hidden" name="deductions[{{ $govd_id }}][item]" value="{{ $deduction->post_title }}">
                                        <tr>
                                            <td>{{ $deduction->post_title }}</td>
                                            <td>

                                                <div class="input-group">
                                                    <span class="input-group-addon">P</span>
                                                    <input type="text" id="deduction-{{ $govd_id }}" name="deductions[{{ $govd_id }}][amount]" class=" form-control text-right numeric input-sm gov-deductions numeric" placeholder="0.00" 
                                                    value="{{ @$govd->$govd_id->amount }}" readonly>
                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="portlet light bordered">
                                <h4 class="text-danger">Other Deductions</h4>

                                <input type="hidden" name="add_deductions[0][item]" value="">
                                <input type="hidden" name="add_deductions[0][amount]" value="">

                                <div class="mt-repeater">
                                    <div data-repeater-list="add_deductions">

                                        <?php $deductions = $post->select_posts(['post_type' => 'deduction'], [], []); ?>

                                        @if(@$payroll->add_deductions)
                                        @foreach( json_decode($payroll->add_deductions) as $ad )
                                        <div data-repeater-item="" class="mt-repeater-item">
                                            <div class="row mt-repeater-row">

                                                <div class="col-md-7 input-group-sm">
                                                    {{ Form::select('item', ['' => 'Select Item'] + $deductions, @$ad->item, ['class' => 'form-control select2']) }}
                                                    <input type="hidden" name="name" class="item-name" value="{{ @$ad->name }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">P</span>
                                                        <input type="text" class="numeric form-control text-right input-sm t-d sum" data-target=".t-d" name="amount" placeholder="0.00" value="{{ @$ad->amount }}" min="0">
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-right">
                                                     <a data-repeater-delete="" class="btn btn-default mt-repeater-delete btn-sm">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div data-repeater-item="" class="mt-repeater-item">
                                            <div class="row mt-repeater-row">

                                                <div class="col-md-7 input-group-sm">
                                                    {{ Form::select('item', ['' => 'Select Item'] + $deductions, '', ['class' => 'form-control select2']) }}
                                                    <input type="hidden" name="name" class="item-name" value="">
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">P</span>
                                                        <input type="text" class="numeric form-control text-right input-sm t-d sum" data-target=".t-d" name="amount" placeholder="0.00" value="" min="0">
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-right">
                                                     <a data-repeater-delete="" class="btn btn-default mt-repeater-delete btn-sm">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>                                        
                                        @endif

                                    </div>
                                    <button type="button" data-repeater-create="" class="btn btn-outline red mt-repeater-add btn-xs margin-top-10">
                                        <i class="fa fa-plus"></i> Add Deductions
                                    </button>

                                </div>

                            </div>
                        </div>
                        <!-- END DEDUCTIONS -->


                    </div>

                    <button type="submit" class="hide"></button>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>

<div style="margin-top:40px;"></div>

<div class="form-actions-fixed uppercase">

    <div class="col-md-3 col-xs-6">
        <button type="button" class="btn-submit btn btn-primary margin-top-10 btn-xs"><i class="fa fa-check"></i> Save Changes</button>

        @if( @$payroll->post_status )
        <a href="{{ URL::route('app.payroll.payslip', ['post_title' => $info->id, 'post_name' => $post_name]) }}" 
        class="btn green btn-outline btn-xs uppercase margin-top-10 btn-preview"><i class="fa fa-print"></i> <span class="hidden-xs">Payslip</span></a>
        @endif

        <h5>Basic Pay :<br> <strong class="total-basic-pay">{{ number_format($total_basic_pay, 2) }}</strong></h5>
    </div>

    <div class="col-md-3 hidden-sm hidden-xs">
        <h5 class="margin-top-10 no-margin"><small class="text-primary">Other Earnings :</small></h5> <strong class="total-earnings">{{ number_format($total_earnings, 2) }}</strong>
        <h5 class="no-margin"><small class="text-danger">Other Deductions :</small></h5>  <strong class="total-deductions">{{ number_format($total_deductions, 2) }}</strong>
    </div>

    <div class="col-md-3 hidden-sm hidden-xs">
        <h5 class="margin-top-10 no-margin"><small class="text-danger">Government Deductions :</small></h5>  <strong class="total-gov-deductions nan-zero">{{ number_format($gov_deductions, 2) }}</strong>
        <h5 class="no-margin"><small>Gross Pay :</small></h5>  <strong class="gross-pay nan-zero">{{ number_format($gross_pay, 2) }}</strong>
    </div>

    <div class="col-md-2 col-xs-6">
         <h5 class="margin-top-10 no-margin"><small>With-Holding Tax :</small></h5> <strong class="tax-withheld nan-zero">{{ number_format($tax_withheld, 2) }}</strong>
         <h5 class="no-margin"><small>Net Pay :</small></h5>  <strong class="net-pay nan-zero">{{ number_format($net_pay, 2) }}</strong>   
    </div>

</div>
@endsection


@section('top_style')
<style>
.form-actions-fixed {
    padding: 0px 5px;
    margin: 0 0 0 -20px;
    background: #f5f5f5;
}
.form-control {
    z-index: 0!important;    
}
.mt-repeater .mt-repeater-item {
    border-bottom: 0!important;
    padding-bottom: 5px;
    margin-bottom: 0;
}
.mt-repeater .mt-repeater-delete {
    margin: 1px 0 0 -22px;
    padding: 5px!important;
}
.mt-repeater .mt-repeater-item:first-child 
 .mt-repeater-delete {
    display: inline-block;
}
.btn-clear, .btn-edit {
    padding: 5px!important;    
}
.form-control {
    font-size: 1em;
    color: #000;
}
input {
    min-width: 100px;    
}
.ed, .t-d, .gov-deductions { color: #e73d4a; }
.img-thumbnail { max-height: 200px; }
.bg-profile {
    background: #f5f5f5;
    padding: 10px 5px;
    margin-right: 0;
    border-bottom: 3px solid #e4e4e4;
}
.icon {
    color: rgba(0,0,0,0.4);
    margin: 13px 10px 0;
    font-size: 2.1em;
}
.icon-box {
    display: flex;
    margin: 5px 0;
    line-height: 17px;
}
</style>
@stop
@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
<script>

var gov_cal_url = '{{ URL::route('app.deductions.govenrment.calculator') }}',
    tax_cal_url = '{{ URL::route('app.taxes.calculator') }}',
    payroll_period = '{{ $payroll_period }}';


var input_total_basic_pay         = $('[name="total[basic_pay]"]'),
    input_total_earnings          = $('[name="total[earnings]"]'),
    input_total_deductions        = $('[name="total[deductions]"]'),
    input_total_ytd_gross_income  = $('[name="total[ytd_gross_income]"]'),
    input_total_ytd_tax_withheld  = $('[name="total[ytd_tax_withheld]"]'),
    input_tax_withheld            = $('[name="total[tax_withheld]"]'),
    input_total_gross_pay         = $('[name="total[gross_pay]"]'),
    input_total_net_pay           = $('[name="total[net_pay]"]'),
    input_total_overtime          = $('[name="total[overtime]"]'),
    input_total_night             = $('[name="total[night]"]'),
    input_total_holiday           = $('[name="total[holiday]"]'),
    input_total_allowance         = $('[name="total[allowance]"]'),
    input_gov_deductions          = $('[name="total[gov_deductions]"]'),
    input_gross_pay               = $('[name="total[gross_pay]"]'),
    input_earnings_deductions     = $('[name="total[earnings_deductions]"]'),
    input_basic_pay               = $('[name="basic_pay"]');

var text_total_earnings         = $('.total-earnings'),
    text_total_deductions       = $('.total-deductions'),
    text_total_basic_pay        = $('.total-basic-pay'),
    text_tax_withheld           = $('.tax-withheld'),
    text_total_gov_deductions   = $('.total-gov-deductions'),
    text_gross_pay              = $('.gross-pay'),
    text_net_pay                = $('.net-pay'),
    nan_zero                    = $('.nan-zero');


$(document).on('keyup', '.ot-h, .nd-h, .hd-h, .ed-h', function() {
    var eh = $(this).val(),
        hr = $('[name=hourly_rate]'),
        target = $(this).data('target');

    var ta = (eh * hr.val()).toFixed(2);
    $(this).closest('tr').find(target).val( ta );
    calculate($(this));
});  

function calculate(t) {

    var is_total = t.hasClass('is-total');

    var ed = ot = nd = hd = aw = oe = gd = total_deductions = 0;

    /* START COMPUTE EARNINGS DEDUCTIONS */
    $('.ed').each(function() {
        ed += Number( $(this).val() );
    });
    /* END COMPUTE EARNINGS DEDUCTIONS */

    /* START COMPUTE OVERTIME */
    $('.hd').each(function() {
        hd += Number( $(this).val() );
    });
    hd = hd.toFixed(2);
    if( ! is_total ) input_total_holiday.val( hd ); 
    /* END COMPUTE OVERTIME */

    /* START COMPUTE OVERTIME */
    $('.ot').each(function() {
        ot += Number( $(this).val() );
    });
    ot = ot.toFixed(2);
    if( ! is_total ) input_total_overtime.val( ot ); 
    /* END COMPUTE OVERTIME */

    /* START COMPUTE NIGHT */
    $('.nd').each(function() {
        nd += Number( $(this).val() );
    });
    nd = nd.toFixed(2);
    if( ! is_total ) input_total_night.val( nd ); 
    /* END COMPUTE NIGHT */

    /* START COMPUTE NIGHT */
    $('.aw').each(function() {
        aw += Number( $(this).val() );
    });
    aw = aw.toFixed(2);
    if( ! is_total ) input_total_allowance.val( aw ); 
    /* END COMPUTE NIGHT */

    /* START COMPUTE OTHER EARNINGS */
    $('.oe').each(function() {
        oe += Number( $(this).val() );
    });
    /* END COMPUTE EARNINGS */
    
    to = input_total_overtime.val() ? parseFloat(input_total_overtime.val()) : 0;
    tn = input_total_night.val() ? parseFloat(input_total_night.val())  : 0;
    th = input_total_holiday.val() ? parseFloat(input_total_holiday.val()) : 0;
    ta = input_total_allowance.val() ? parseFloat(input_total_allowance.val()) : 0;
    oe = oe ? oe : 0;

    /* START COMPUTE EARNINGS */
    total_earnings = to + tn + th + ta + oe;

    text_total_earnings.html( number_format(total_earnings.toFixed(2)) );
    input_total_earnings.val( total_earnings.toFixed(2) );
    /* END COMPUTE EARNINGS */

    /* START COMPUTE DEDUCTIONS */
    $('.t-d').each(function() {
        total_deductions += Number( $(this).val() );
    });

    input_earnings_deductions.val(ed);
    total_deductions = total_deductions.toFixed(2);
    input_total_deductions.val( total_deductions ); 
    text_total_deductions.html( number_format(total_deductions) );
    /* END COMPUTE DEDUCTIONS */

    /* START NET BASIC */
    total_basic_pay = parseFloat(input_basic_pay.val()) + parseFloat(input_total_earnings.val()) - parseFloat(input_earnings_deductions.val()) - parseFloat(input_total_deductions.val());    

    input_total_basic_pay.val( total_basic_pay.toFixed(2) );
    text_total_basic_pay.html( number_format(total_basic_pay.toFixed(2)) );
    /* END NET BASIC */

    update_deductions( input_total_basic_pay.val() );


    /* Reset nan zero value */
    if( total_basic_pay <= 0 ) {
        nan_zero.val('0.00');
        nan_zero.html('0.00');        
    }
}



function update_deductions(basic_pay) {

    var gd = 0;

    $.ajax({
        url: gov_cal_url,
        method: "POST",
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { salary : basic_pay },
        crossDomain: true,
        success: function(data){
            $.each(data, function(key, val) {
                $('#deduction-'+val.id).val(val.employee_share);
            });

            /* START SUM GOVERNMENT DEDUCTION */
            $('.gov-deductions').each(function() {
                gd += Number( $(this).val() );
            });
            /* END SUM GOVERNMENT DEDUCTION */

            /* START GOVERNMENT DEDUCTION */
            input_gov_deductions.val( gd.toFixed(2) );
            text_total_gov_deductions.html( number_format(gd.toFixed(2)) );
            /* END GOVERNMENT DEDUCTION */


            /* START GROSS PAY */
            gross_pay = input_total_basic_pay.val() - input_gov_deductions.val()
            input_gross_pay.val( gross_pay.toFixed(2) );
            text_gross_pay.html( number_format(gross_pay.toFixed(2)) );
            /* END GROSS PAY */

            update_tax_withheld( input_gross_pay.val() );

        }
    });
}


function update_tax_withheld(gross_pay) {
    $.ajax({
        url: tax_cal_url,
        method: "GET",
        dataType: 'json',
        data: { payroll_period : payroll_period, code : $('.tax-code').text(), gross_pay : gross_pay },
        success: function(data){
            input_tax_withheld.val( data.amount );
            text_tax_withheld.html( data.formatted );


            /* START NET PAY */
            net_pay = input_total_gross_pay.val() - data.amount;
            input_total_net_pay.val( net_pay.toFixed(2) );
            text_net_pay.text( number_format(net_pay.toFixed(2)) );
            /* END NET PAY */
        }
    });
}




$(document).on('change', 'select', function() {
    var val = $(this).val() ? $(this).select2('data')[0].text : '';
    $(this).closest('.mt-repeater-item').find('.item-name').val( val );
});  




$(document).on('click', '.btn-edit', function() {
    if( input_basic_pay.attr("readonly") ) {
        input_basic_pay.removeAttr('readonly');
    } else {
        input_basic_pay.attr('readonly', 'readonly');            
    }

});  



$(document).on('keyup', '.sum, [name="basic_pay"]', function() {
    calculate($(this));
});  

$(document).on('click', '.btn-clear, .mt-repeater-delete', function() {
    $(this).closest('.mt-repeater-item').find('input').val('');
    $(this).closest('tr').find('input').val('');
    calculate($('input'));
});  



$(document).on('click', '.show', function() {
    var target = $(this).data('target');

    $(target).hide();

    if( $(this).is(':checked') ) $(target).show();
});  

$(document).on('ready',  function() {
    calculate($('.sum'));
});


$('body').addClass('page-sidebar-closed');
$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');


</script>
@stop
