<h5 class="uppercase page-title">Organizational Assignment</h5>

<div class="form-group margin-top-30">

    <div class="col-md-6">
        <h5>Department</h5>
        {{ Form::select('department', ['' => 'Select Department'] + $post->select_posts(['post_type' => 'department']), Input::old('department', $info->department), ['class' => 'form-control select2'] )  }}
    </div>
    <div class="col-md-6">
        <h5>Position</h5>
        {{ Form::select('position', ['' => 'Select Position'] + $post->select_posts(['post_type' => 'position']), Input::old('position', $info->position), ['class' => 'form-control select2'] )  }}
    </div>
</div>

<div class="form-group">

    <div class="col-md-6">
        <h5>Job Type</h5>
        {{ Form::select('job_type', ['' => 'Select Job Type'] + $post->select_posts(['post_type' => 'job-type']), Input::old('job_type', $info->job_type), ['class' => 'form-control select2'] )  }}
    </div>
    <div class="col-md-6">
        <h5>Shift</h5>
        {{ Form::select('shift', ['' => 'Select Shift'] + $post->select_posts(['post_type' => 'shift']), Input::old('shift', $info->shift), ['class' => 'form-control select2'] )  }}
    </div>
</div>

<hr>

<h5 class="uppercase sbold text-primary">Dates</h5>

<div class="form-group">
    <div class="col-md-4">
        <h5>Date Hired <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="date_hired" placeholder="Date Hired" value="{{ Input::old('date_hired', $info->date_hired) }}">
    </div>
    <div class="col-md-4">
        <h5>Probation Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="probation_date" placeholder="Probation Date" value="{{ Input::old('probation_date', $info->probation_date) }}">
    </div>
    <div class="col-md-4">
        <h5>Date Regularized <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="date_regularized" placeholder="Date Regularized" value="{{ Input::old('date_regularized', $info->date_regularized) }}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>End of Contract Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="end_contract" placeholder="End of Contract Date" value="{{ Input::old('end_contract', $info->end_contract) }}">
    </div>
    <div class="col-md-4">
        <h5>Date Resigned <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="date_resigned" placeholder="Date Resigned" value="{{ Input::old('date_resigned', $info->date_resigned) }}">
    </div>
</div>