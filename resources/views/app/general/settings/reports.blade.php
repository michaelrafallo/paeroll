<div class="form-group">
    <label class="col-md-3 control-label">Company Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="{{ @$info->company_name }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Contact Person</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="report_person" placeholder="Contact Person" value="{{ @$info->report_person }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Designation</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="report_designation" placeholder="Designation" value="{{ @$info->report_designation }}">
    </div>
</div>

<div class="form-group margin-top-40">
	<label class="col-md-3 control-label">Header</label>
    <div class="col-md-8">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="enable_header" value="1" {{ checked(@$info->enable_header, 1) }}> Enabled
                <span></span>
            </label>    
            <label class="mt-radio">
                <input type="radio" name="enable_header" value="0" {{ checked(@$info->enable_header, 0) }}> Disabled
                <span></span>
            </label>            
        </div>
	</div>

    <label class="col-md-3 control-label">Address</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="report_address" placeholder="Address" value="{{ @$info->report_address }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Contact Number</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="report_contact_no" placeholder="Contact Number" value="{{ @$info->report_contact_no }}">
    </div>
</div>

<div class="form-group margin-top-40">
    <label class="col-md-3 control-label">Footer</label>
    <div class="col-md-8">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="enable_footer" value="1" {{ checked(@$info->enable_footer, 1) }}> Enabled
                <span></span>
            </label>    
            <label class="mt-radio">
                <input type="radio" name="enable_footer" value="0" {{ checked(@$info->enable_footer, 0) }}> Disabled
                <span></span>
            </label>            
        </div>
    </div>

    <label class="col-md-3 control-label">Footer</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="report_footer" placeholder="Footer" value="{{ @$info->report_footer }}">
    </div>
</div>