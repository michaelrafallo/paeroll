<a href="{{ URL::route('app.payroll.payslip', ['post_name' => $post_name]) }}" class="btn green btn-outline btn-xs uppercase btn-preview"><i class="fa fa-print"></i> Generate Payslip</a>

<small class="pull-right uppercase text-muted"><b>{{ number_format($count) }}</b> Record{{ is_plural($count) }} Found</small>

<div class="form-body margin-top-30">
    <div class="row">
        <form method="get" class="form-horizontal">

            <div class="col-md-12">
                <div class="well">
                    <div class="row">
    
                        <div class="col-md-4">
                            <div class="input-group input-group-sm input-large daterange-picker input-daterange">
                                <input type="text" class="form-control period" name="from" value="{{ $from }}">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control period" name="to" value="{{ $to }}"> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" name="s" placeholder="Search Name" value="{{ Input::get('s') }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn blue btn-sm"><i class="fa fa-search"></i> Search</button>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ URL::route('app.payroll.index') }}" class="btn btn-default btn-sm">Reset</a>
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
                                    <div class="col-md-4">         
                                    <h5>Status</h5>                           
                                        {{ Form::select('status', ['' => 'All Status'] + user_status(),  Input::get('status'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-4">         
                                    <h5>Gender</h5>                           
                                        {{ Form::select('gender', ['' => 'All Gender'] + genders(),  Input::get('status'), ['class' => 'select2 form-control']) }}
                                    </div>
                                    <div class="col-md-4">         
                                    <h5>Civil Status</h5>                           
                                        {{ Form::select('civil_status', ['' => 'All Civil Status'] + civil_status(),  Input::get('status'), ['class' => 'select2 form-control']) }}
                                    </div>
                                </div>
                    
                                <div class="form-group">                        

                                    <div class="col-md-4">
                                        <h5>Department</h5>
                                        {{ Form::select('department', ['' => 'All Department'] + $post->select_posts('department'),  Input::get('department'), ['class' => 'select2 form-control']) }}
                                    </div>

                                    <div class="col-md-4">
                                        <h5>Position</h5>
                                        {{ Form::select('position', ['' => 'All Position'] + $post->select_posts('position'),  Input::get('position'), ['class' => 'select2 form-control']) }}
                                    </div>

                                    <div class="col-md-4">
                                        <h5>Jon Type</h5>
                                        {{ Form::select('job_type', ['' => 'All Job Type'] + $post->select_posts('job-type'),  Input::get('job_type'), ['class' => 'select2 form-control']) }}
                                    </div>
                                </div>                            

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Sort By</h5>
                                        {{ Form::select('sort', user_sort_by(),  Input::get('sort'), ['class' => 'select2 form-control']) }}
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

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" class="reset-period" value="1" data-from="{{ $set_pay_period_from }}" data-to="{{ $set_pay_period_to }}"> 
                                            Use pay period from settings
                                            <div class="help-inline">
                                            {{ date_formatted(date_formatted_b($set_pay_period_from)) }} <i class="fa fa fa-long-arrow-right"></i>
                                            {{ date_formatted(date_formatted_b($set_pay_period_to)) }}
                                            </div>
                                            <span></span>
                                        </label>
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

            @if( Input::get('post_status') == 'trash' )
            <input type="hidden" name="type" value="trash">
            @endif

        </form>
    </div>
</div>