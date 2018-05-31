@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Tax Tables</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.taxes.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All {{ $label }}
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->


@include('notification')

<div class="portlet light bordered">

    <div class="tax-tables">
    @include('app.taxes.temp.tables')
    </div>

</div>


<div class="modal fade form-modal" id="popupModal"  tabindex="1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-body">
            <form class="form-horizontal" method="post" action="{{ URL::route('app.taxes.tables.update') }}">
                {{ csrf_field() }}
                <input type="hidden" name="target">
                <input type="hidden" name="id">

                <div class="form-group">
                    <h5 class="col-md-12 sbold">Exemption <span class="text-danger">*</span></h5>
                    <div class="col-md-12">
                        <h5>Amount</h5>
                        <input type="number" class="form-control rtip" name="exemption_amount" placeholder="0.00" step="any" min="0">   
                        <span id="exemption_amount" class="msg-error"></span>               
                    </div>
                    <div class="col-md-6">
                        <h5>Percent <span class="text-danger">*</span></h5>
                        <div class="input-group">
                            <input type="number" class="form-control rtip percent" data-target=".exemption_rate" name="exemption_percent" placeholder="0" step="any" min="0">
                            <span class="input-group-addon">%</span>
                        </div>        
                        <span id="exemption_percent" class="msg-error"></span>
                    </div>
                    <div class="col-md-6">
                        <h5>Rate <span class="text-danger">*</span></h5>
                        <input type="number" class="form-control rtip exemption_rate" name="exemption_rate" placeholder="0.00" step="any" min="0">  
                        <span id="exemption_rate" class="msg-error"></span>             
                    </div>
                </div>

                <h5 class="sbold">Excess <span class="text-danger">*</span></h5>
                <input type="number" name="excess" class="form-control rtip" step="any" min="0">
                <span id="excess" class="msg-error"></span>
            </form>      
        </div>

        <div class="modal-footer">
        <a class="btn btn-primary confirm uppercase" data-href="#" data-index="" data-id="" data-target=""><i class="fa fa-check"></i> Save Changes</a>
        <button class="btn btn-default uppercase" aria-hidden="true" data-dismiss="modal" class="close" type="button">Close</button> 
        <span class="msg-error"></span>           
        </div>
       
    </div>
  </div>
</div>
@endsection


@section('top_style')
@stop

@section('bottom_style')
<style>
.table-hover>tbody>tr:hover>td.editable:hover {
    cursor: pointer;
    background: #fff6a4!important;
}  

.page-header.navbar.navbar-fixed-top, .page-header.navbar.navbar-static-top {
    z-index: 3;
}

.blockMsg {  z-index: 6 }
.modal { z-index: 5; }
.modal-backdrop { z-index: 4; }
</style>
@stop

@section('bottom_plugin_script') 

@stop

@section('bottom_script')
<script>

var blockUImsg = 'Updating tax table ...';



var id     = $('[name="id"]'),
    key    = $('[name="key"]'),
    target = $('[name="target"]'),
    modal  = $('.form-modal');


$(document).on('click','.editable', function() {
    var d_id     = $(this).attr('data-id'),
        d_key    = $(this).attr('data-key')
        d_val    = $(this).attr('data-val')
        d_target = $(this).attr('data-target');

    $('.msg-error').html('');

    modal.modal('show');
    modal.find('[name="id"]').val(d_id);
    modal.find('[name="target"]').val(d_target);
    modal.find('[name="key"]').val(d_key);

    var data = JSON.parse(d_val);

    $.each( data, function( key, value ) {
      $('[name="'+key+'"]').val( value );
    });
});



$(document).on('click', '.confirm', function(e) {
    
    e.preventDefault();

    var $this    = $(this);
    var formData = $(this).closest('.form-modal').find('form');
    var url      = formData.attr('action');

    $('.msg-error').html('');
    
    blockUI(blockUImsg);

    $.post(url, form_to_json(formData), function(response) {
              
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
            $('.tax-tables').html( response );
            modal.modal('hide');
        }         
        $.unblockUI();  
    });

});

</script>
@stop
