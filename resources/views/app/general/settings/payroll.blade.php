
<div class="form-group">
    <label class="col-md-3 control-label">Payroll Period <span class="required">*</span></label>
    <div class="col-md-3">
        <div class="rtip">
        {{ Form::select('payroll_period', payroll_period(), @$info->payroll_period, ['class' => 'form-control select2']) }}
        </div>
    </div>

</div>


<div class="form-group">
    <label class="control-label col-md-3">Next Pay Period <span class="required">*</span><br> <small class="text-muted">( MM-DD-YYYY )</small></label>
    <div class="col-md-4">
        <div class="input-group input-large daterange-picker input-daterange">
            <input type="text" class="form-control" name="pay_period_from" value="{{ @$info->pay_period_from }}">
            <span class="input-group-addon"> to </span>
            <input type="text" class="form-control" name="pay_period_to" value="{{ @$info->pay_period_to }}"> 
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Payroll Preparation <span class="required">*</span></label>
    <div class="col-md-3">
    	<div class="rtip">
        {{ Form::select('payroll_preparation', payroll_preparation(), @$info->payroll_preparation, ['class' => 'form-control select2']) }}
        </div>
    </div>
    <div class="col-md-6">
    	<span class="help-inline">before cutoff date</span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Pay Day <span class="required">*</span></label>
    <div class="col-md-3">
    	<div class="rtip">
        {{ Form::select('pay_day', payroll_preparation(), @$info->pay_day, ['class' => 'form-control select2']) }}
        </div>
    </div>
    <div class="col-md-6">
    	<span class="help-inline">after cutoff date</span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Working Hours <span class="required">*</span></label>
    <div class="col-md-3">
    	<div class="rtip">
        <input type="text" name="work_hours" value="{{ @$info->work_hours }}" class="form-control numeric">
        </div>
    </div>
    <div class="col-md-6">
    	<span class="help-inline">number of working hours a day</span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Other Earnings <span class="required">*</span></label>
    <div class="col-md-3">
        <div class="rtip">
        <input type="text" name="limit_other_earnings" value="{{ @$info->limit_other_earnings }}" class="form-control numeric">
        </div>
    </div>
    <div class="col-md-6">
        <span class="help-inline">display limit of other earnings in payslip</span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Other Deductions <span class="required">*</span></label>
    <div class="col-md-3">
        <div class="rtip">
        <input type="text" name="limit_other_deductions" value="{{ @$info->limit_other_deductions }}" class="form-control numeric">
        </div>
    </div>
    <div class="col-md-6">
        <span class="help-inline">display limit of other earnings in payslip</span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Working Days in a year<span class="required">*</span></label>
    <div class="col-md-3">
    	<div class="rtip">
        <input type="text" name="work_days_in_year" value="{{ @$info->work_days_in_year }}" class="form-control work_days_in_year numeric">
        </div>
    </div>
    <div class="col-md-6">
    	    <span class="help-inline">Note: Total working days in a year is <b><a href="#" data-val="313" data-target=".work_days_in_year" class="set-click">313</a></b> days if you’re working <b>Mondays to Saturday</b> and <b><a href="#" data-val="261" data-target=".work_days_in_year" class="set-click">261</a></b> days if you’re working <b>Mondays to Fridays</b>.
</span>
    </div>
</div>


<div class="form-group margin-top-40">
	<label class="col-md-3 control-label">Enable Post Types</label>
    <div class="col-md-8">
	    <div class=" mt-checkbox-list">
			<label class="mt-checkbox">
			    <input type="checkbox" value="1"> Earnings
			    <span></span>
			</label>	
			<label class="mt-checkbox">
			    <input type="checkbox" value="1"> Deductions
			    <span></span>
			</label>	
			<label class="mt-checkbox">
			    <input type="checkbox" value="1"> Contributions
			    <span></span>
			</label>	
			<label class="mt-checkbox">
			    <input type="checkbox" value="1"> Leaves
			    <span></span>
			</label>	
	    	<label class="mt-checkbox">
			    <input type="checkbox" value="1"> Events
			    <span></span>
			</label>	
	    </div>
	</div>
</div>