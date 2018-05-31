@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">{{ $info->post_title }} Table</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.deductions.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-plus"></i> Government Deductions
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

@include('notification')

<div class="portlet light bordered">

    <div class="row">

        <div class="col-md-9">

            <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Salary Range</th>
                        <th class="text-center">Employee Share</th>
                        <th class="text-center">Employer Share</th>
                        <th class="text-center">Total</th>
                        <th class="text-center"><a href="{{ URL::route('app.deductions.table', $info->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add New </a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $order = 0; ?>
                    @foreach($rows as $row)
                    <?php $postmeta = get_meta( $row->postMetas()->get() ); ?>
                    <tr>
                        <td>{{ $order = @$row->post_order }}</td>
                        <td class="text-right">

                        @if( @$postmeta->salary_range_from == 0)
                            {{ number_format(@$postmeta->salary_range_to, 2) }}
                            <b>and below</b>
                        @elseif( @$postmeta->salary_range_to == 9999999)
                            {{ number_format(@$postmeta->salary_range_from, 2) }} 
                            <b>and above</b>
                        @else
                            {{ number_format(@$postmeta->salary_range_from, 2) }} 
                            <i class="fa fa-long-arrow-right text-muted"></i>
                            {{ number_format(@$postmeta->salary_range_to, 2) }}
                        @endif

                        </td>
                        <td class="text-right">
                            {{ @$percentage ? '%' : '' }}                            
                            {{ number_format(@$postmeta->employee_share, 2) }}
                        </td>
                        <td class="text-right">
                            {{ @$percentage ? '%' : '' }}  
                            {{ number_format(@$postmeta->employer_share, 2) }}
                        </td>
                        <td class="text-right">{{ @$percentage ? '%' : '' }} {{ number_format(@$postmeta->total, 2) }}</td>
                        <td>
                            <div class="text-right">                    

                                <a href="{{ URL::route('app.deductions.table', [$info->id, 'gid' => $row->id]) }}" class="btn green btn-xs uppercase">Edit</a>

                                <a href="#" class="popup btn btn-xs btn-default uppercase"
                                    data-href="{{ URL::route('app.deductions.destroy', [$row->id, query_vars()]) }}" 
                                    data-toggle="modal"
                                    data-target=".popup-modal" 
                                    data-title="Confirm Delete"
                                    data-body="Are you sure you want to delete ID: <b>#{{ $row->id }}</b>?">Delete</a> 

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>        

            @if( ! count($rows) )
            <p class="well">No record found!</p>
            @endif

            </div>
        </div>

        <div class="col-md-3">
                    
            <form action="" class="form-horizontal" method="post">

            {{ csrf_field() }}
            <input type="hidden" name="gid" value="{{ Input::get('gid') }}">

            <div class="form-body">

                <h5 class="sbold">Salary Range</h5>

                <div class="form-group">
                    <div class="col-md-12">
                        <label>From<span class="required">*</span></label>

                        <input type="number" class="form-control rtip text-right sfrom" name="salary_range_from" placeholder="0.00" value="{{ Input::old('salary_range_from', @$table->salary_range_from ) }}"  min="0" step="any">
                            <span class="help-inline">set 0 as <a href="" class="set-click" data-target=".sfrom" data-val="0">below</a> amount value</span>

                        <!-- START error message -->
                        {!! $errors->first('salary_range_from','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                        <!-- END error message -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>To<span class="required">*</span></label>

                        <input type="number" class="form-control rtip text-right sto" name="salary_range_to" placeholder="0.00" value="{{ Input::old('salary_range_to', @$table->salary_range_to) }}"  min="0" step="any">
                        <span class="help-inline">set 9999999 as <a href="" class="set-click" data-target=".sto" data-val="9999999">above</a> amount value</span>

                        <!-- START error message -->
                        {!! $errors->first('salary_range_to','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                        <!-- END error message -->
                    </div>
                </div>

                <h5 class="sbold">Share</h5>


                <div class="form-group">
                    <div class="col-md-6">
                        <label>Employer<span class="required">*</span></label>

                        <input type="number" class="form-control rtip text-right" name="employer_share" placeholder="0.00" value="{{ Input::old('employer_share', @$table->employer_share) }}" min="0" step="any">
                        <!-- START error message -->
                        {!! $errors->first('employer_share','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                        <!-- END error message -->
                    </div>
                    <div class="col-md-6">
                        <label>Employee<span class="required">*</span></label>

                        <input type="number" class="form-control rtip text-right" name="employee_share" placeholder="0.00" value="{{ Input::old('employee_share', @$table->employee_share) }}" min="0" step="any">
                        <!-- START error message -->
                        {!! $errors->first('employee_share','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                        <!-- END error message -->
                    </div>
                </div>                     

                <div class="form-group">
                    <div class="col-md-12">
                        <label>Order #</label>

                        <input type="number" class="form-control rtip text-right" name="order" placeholder="0" 
                        value="{{ @$table->post_order ? @$table->post_order : $order + 1 }}" min="0">
                        <!-- START error message -->
                        {!! $errors->first('order','<span class="help-block"><span class="text-danger">:message</span></span>') !!}
                        <!-- END error message -->
                    </div>
                </div>  

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>

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
<script>
$(document).on('click','.popup', function() {
    var $this  = $(this);
    var $title = $this.data('title');
    var $body  = $this.data('body');
    var $href  = $this.data('href');
    var $target = $(this).attr('target');

    $target = ($target == '_blank') ? '_blank' : '';

    $('.popup-modal a.confirm').attr('data-target', $target);
    $('.popup-modal a.confirm').attr('data-href', $href);
    $('.popup-modal .modal-title').html($title);
    $('.popup-modal .modal-body').html($body);
});

$(document).on('click','.popup-modal .modal-footer a', function(e) {
    e.preventDefault();
    $(this).html('Processing ...').attr('disabled', 'disabled');

    var $target = $(this).attr('data-target');
    var $href = $(this).attr('data-href');

    location.href = $href;   

});
    
</script>
@stop
