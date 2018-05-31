
@if(Input::get('type') == 'trash')
<a href="{{ URL::route('app.taxes.index') }}">All ({{ number_format($all) }})</a> | 
<b>Trashed ({{ number_format($trashed) }})</b>
@else
<b>All ({{ number_format($all) }})</b> | 
<a href="{{ URL::route('app.taxes.index', ['type' => 'trash']) }}">Trashed ({{ number_format($trashed) }})</a>
@endif

| <a href="{{ URL::route('app.taxes.tables') }}">Tax Tables</a>

<small class="pull-right uppercase text-muted"><b>{{ number_format($count) }}</b> Record{{ is_plural($count) }} Found</small>

<div class="form-body margin-top-20">
    <div class="row">
        <form method="get" class="form-horizontal">

            <div class="col-md-12">
                <div class="well">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="text" name="s" placeholder="Search Name" value="{{ Input::get('s') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn blue btn-sm"><i class="fa fa-search"></i> Search</button>
                            </span>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ URL::route('app.taxes.index') }}" class="btn btn-default btn-sm">Reset</a>
                            <a class="btn btn-outline btn-default btn-sm" data-toggle="modal" href="#basic"> Advanced Search </a>
                        </div>                        
                    </div>
                </div>
            </div>

            <!-- START ADVANCED SEARCH -->
            <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Advanced Search</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-body">

                                <div class="form-group">  
                                    <div class="col-md-3">         
                                    <h5>Status</h5>                           
                                        {{ Form::select('status', ['' => 'All Status'] + user_status(),  Input::get('status'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-3">         
                                    <h5>Period</h5>                           
                                        {{ Form::select('payroll_period', ['' => 'All Period'] + payroll_period(),  Input::get('payroll_period'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-3">         
                                    <h5>Status</h5>                           
                                        {{ Form::select('status', ['' => 'All Status'] + tax_status(),  Input::get('status'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-3">         
                                    <h5>Number of Dependent</h5>                           
                                        {{ Form::select('dependent', [0 => 'None'] + range(0, 4), Input::old('dependent'), ['class' => 'form-control'] ) }}
                                    </div>
                                </div>                      

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Sort By</h5>
                                        {{ Form::select('sort', ['post_order' => 'Order', 'id' => 'ID', 'post_title' => 'Name'],  Input::get('sort'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Order By</h5>
                                        {{ Form::select('order', order_by(),  Input::get('order'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <h5>Per Page</h5>
                                    <div class="col-md-4">
                                        {{ Form::select('rows', per_page(),  Input::get('rows'), ['class' => 'select2 form-control']) }}
                                    </div>
                                </div>    
                                
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn green">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ADVANCED SEARCH -->

            @if( Input::get('type') == 'trash' )
            <input type="hidden" name="type" value="trash">
            @endif

        </form>
    </div>
</div>