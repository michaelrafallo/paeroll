
<h4 class="uppercase page-title">Salary</h4>

<div class="form-group">
    <div class="col-md-4">
        <h5>Monthly Rate <span class="required">*</span></h5>
        <div class="input-group">
            <input type="text" class="form-control rtip" name="monthly_rate" placeholder="Monthly Rate" value="{{ Input::old('monthly_rate', $info->monthly_rate) }}">
            <div class="input-group-btn">
                <button type="button" class="btn btn-outline blue rate" data-target="monthly_rate"><i class="fa fa-calculator"></i></button>
            </div>
        </div>
        <!-- START error message -->
        {!! $errors->first('monthly_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
        <!-- END error message -->
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>Daily Rate <span class="required">*</span></h5>
        <div class="input-group">
            <input type="text" class="form-control rtip" name="daily_rate" placeholder="Daily Rate" value="{{ Input::old('daily_rate', $info->daily_rate) }}">
            <div class="input-group-btn">
                <button type="button" class="btn btn-outline blue rate" data-target="daily_rate"><i class="fa fa-calculator"></i></button>
            </div>
        </div>
        <!-- START error message -->
        {!! $errors->first('daily_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
        <!-- END error message -->
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>Hourly Rate <span class="required">*</span></h5>
        <div class="input-group">
            <input type="text" class="form-control rtip" name="hourly_rate" placeholder="Hourly Rate" value="{{ Input::old('hourly_rate', $info->hourly_rate) }}">
            <div class="input-group-btn">
                <button type="button" class="btn btn-outline blue rate" data-target="hourly_rate"><i class="fa fa-calculator"></i></button>
            </div>
        </div>
        <!-- START error message -->
        {!! $errors->first('hourly_rate','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
        <!-- END error message -->
    </div>
</div>