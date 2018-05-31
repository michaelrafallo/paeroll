@extends('layouts.app')

@section('content')

@include('notification')



<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <h1 class="page-title uppercase">Payroll</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <p class="no-margin margin-top-20 uppercase">
                <span class="text-muted">Pay Period :</span> {{ $pay_from }} <i class="fa fa-long-arrow-right"></i> {{ $pay_to }}<br>
                <span class="text-danger">Cutoff Date : {{ $cutoff }}</span>
            </p> 

        </div>
    </div>
</div>
<!-- END PAGE BAR -->

<div class="portlet light bordered">
    @include('app.payroll.search')

    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="3">Details</th>
                <th>Payroll</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <?php 
                $usermeta = get_meta( $row->userMetas()->get() ); 
                $processed = $post->where('post_name', $post_name)->where('post_title', $row->id)->exists();
            ?>
            <tr>
                <td style="min-width:60px;max-width:60px;">
                    <img src="{{ has_photo(@$usermeta->profile_picture) }}" class="img-responsive"> 
                </td>
                <td>
                    <h4 class="no-margin">
                    <a href="{{ URL::route('app.employees.edit', $row->id) }}">{{ $row->firstname.' '.$row->lastname }}</a></h4>
                    
                    <small class="text-muted">ID: {{ $row->id }}</small>
                    <small>{{ $row->email }}</small>

                    <div class="margin-top-5">
                                            
                        <a href="{{ URL::route('app.payroll.view', $row->id) }}" class="btn green btn-xs uppercase margin-top-10">View Payroll</a>
                        
                        @if( $processed )
                        <a href="{{ URL::route('app.payroll.payslip', ['post_title' => $row->id, 'post_name' => $post_name]) }}" 
                        class="btn green btn-outline btn-xs uppercase margin-top-10 btn-preview">Payslip</a>
                        @endif

                    </div>
                </td>
                <td>
                    <h5>{{ @$post->find($usermeta->job_type)->post_title }} - {{ @$post->find($usermeta->position)->post_title }}</h5>
                    <h5 class="no-margin">{{ @$post->find($usermeta->department)->post_title }}</h5>

                    @if($usermeta->gender == 'male')
                    <h5 class="icon-user tooltips" data-placement="left" data-original-title="{{ ucwords($usermeta->gender) }}"></h5>
                    @else
                    <h5 class="icon-user-female tooltips" data-placement="left" data-original-title="{{ ucwords($usermeta->gender) }}"></h5>
                    @endif  
                    <small> - {{ @$usermeta->tax_code }}
                    <h5 class="no-margin"> {{ @$usermeta->tax_name }}</h5></small>
                </td>

                @if( $processed )
                <td>
                <?php 
                    $payroll = @$post->where('post_name', $post_name)->where('post_title', $row->id)->first(); 
                    $p = json_decode($payroll->post_content);
                ?>
                @if($p)
                <div class="small uppercase">   
                    <div class="row">
                        <div class="col-md-5">Basic</div>
                        <div class="col-md-7">: {{ amount_formatted($p->total->basic_pay) }}</div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-primary">Earnings</div>
                        <div class="col-md-7">: {{ amount_formatted($p->total->earnings) }}</div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-danger">Deductions</div>
                        <div class="col-md-7">: {{ amount_formatted($p->total->deductions) }}</div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-danger">Gov.Deductions</div>
                        <div class="col-md-7">: {{ amount_formatted($p->total->gov_deductions) }}</div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-5 sbold">Gross Pay</div>
                        <div class="col-md-7 sbold">: {{ amount_formatted($p->total->gross_pay) }}</div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-danger">Tax Withheld</div>
                        <div class="col-md-7">: {{ amount_formatted($p->total->tax_withheld) }}</div>                    
                    </div>

                    <div class="row">
                        <div class="col-md-5 sbold">Net Pay</div>
                        <div class="col-md-7 sbold">: {{ amount_formatted($p->total->net_pay) }}</div>                    
                    </div>
                </div>
                @endif
                </td>
                <td><h5 class="margin-top-30 text-center">{{ status_ico($payroll->post_status) }}</h5></td>
                @else
                    <td></td>
                    <td><h5 class="margin-top-30 text-center">{{ status_ico('unprocessed') }}</h5></td>
                @endif

            </tr>
            @endforeach
        </tbody>
    </table>            
    </div>

    @if( ! count($rows) )
    <p class="well"><b>No record found!</b> try boardening your search criteria.</p>
    @endif
</div>

@endsection


@section('top_style')
@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
<script>
$(document).on('click', '.reset-period', function() {
    var from = $(this).data('from'), 
        to = $(this).data('to');
    $('[name="from"]').val(from);
    $('[name="to"]').val(to);
});
$(document).on('click', '.period', function() {
   $('.reset-period').removeAttr('checked');
});
</script>
@stop
