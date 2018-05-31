
<div class="form-group margin-top-40">
    <label class="col-md-3 control-label">Leave Manager</label>
    <div class="col-md-8">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="leave_management" value="1" {{ checked(@$info->leave_management, 1) }}> Enabled
                <span></span>
            </label>    
            <label class="mt-radio">
                <input type="radio" name="leave_management" value="0" {{ checked(@$info->leave_management, 0) }}> Disabled
                <span></span>
            </label>            
        </div>
        <p class="help-block">Modules Included : 
        <li>Leave Management (Leaves, Leave Requests, File a leave)</li>
        </p>
    </div>
</div>