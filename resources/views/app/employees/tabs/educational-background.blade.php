<h5 class="uppercase page-title">Educational Background</h5>      

<h5 class="uppercase sbold margin-top-30 text-primary">Elementary</h5>   

<div class="form-group">
    <div class="col-md-5">
        <h5>School Attended</h5>
        <input type="text" class="form-control" name="elementary_school_attended" placeholder="School Attended" value="{{ Input::old('elementary_school_attended', $info->elementary_school_attended) }}">

        <h5>Inclusive Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="elementary_date" placeholder="Inclusive Date" value="{{ Input::old('elementary_date', $info->elementary_date) }}">
    </div>

    <div class="col-md-7">
        <h5>Address</h5>
        <textarea class="form-control" name="elementary_address" placeholder="Address" rows="5">{{ Input::old('elementary_address', $info->elementary_address) }}</textarea>
    </div>
</div>

<hr>

<h5 class="uppercase sbold text-primary">High School</h5>   

<div class="form-group">
    <div class="col-md-5">
        <h5>School Attended</h5>
        <input type="text" class="form-control" name="high_school_attended" placeholder="School Attended" value="{{ Input::old('high_school_attended', $info->high_school_attended) }}">

        <h5>Inclusive Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="high_school_date" placeholder="Inclusive Date" value="{{ Input::old('high_school_date', $info->high_school_date) }}">
    </div>

    <div class="col-md-7">
        <h5>Address</h5>
        <textarea class="form-control" name="high_school_address" placeholder="Address" rows="5">{{ Input::old('high_school_address', $info->high_school_address) }}</textarea>
    </div>
</div>

<hr>

<h5 class="uppercase sbold text-primary">College</h5>   

<div class="form-group">
    <div class="col-md-5">
        <h5>School Attended</h5>
        <input type="text" class="form-control" name="college_school_attended" placeholder="School Attended" value="{{ Input::old('college_school_attended', $info->college_school_attended) }}">

        <h5>Course</h5>
        <input type="text" class="form-control" name="college_course" placeholder="Course" value="{{ Input::old('college_course', $info->college_course) }}">

        <h5>Inclusive Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
        <input type="text" class="form-control datepicker" name="college_date" placeholder="Inclusive Date" value="{{ Input::old('college_date', $info->college_date) }}" data-date-orientation="top">
    </div>

    <div class="col-md-7">
        <h5>Address</h5>
        <textarea class="form-control" name="college_address" placeholder="Address" rows="5">{{ Input::old('college_address', $info->college_address) }}</textarea>
    </div>
</div>


