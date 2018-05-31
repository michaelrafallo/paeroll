
<div class="form-group margin-top-40">
    <label class="col-md-3 control-label">Attendance</label>
    <div class="col-md-8">
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="attendance" value="1" {{ checked(@$info->attendance, 1) }}> Enabled
                <span></span>
            </label>    
            <label class="mt-radio">
                <input type="radio" name="attendance" value="0" {{ checked(@$info->attendance, 0) }}> Disabled
                <span></span>
            </label>            
        </div>
        <p class="help-block">Modules Included : 
        <li>Events</li> 
        <li>Attendance (Tracker, Manual Punch)</li>
        <li>Biometric System</li>
        </p>
    </div>
</div>