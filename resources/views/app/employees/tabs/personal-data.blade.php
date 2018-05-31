<h4 class="uppercase page-title">Personal Data</h4>

<div class="form-group margin-top-30">
    <div class="col-md-4">
    <h5>First Name</h5>
        <input type="text" class="form-control" name="firstname" placeholder="First Name" value="{{ Input::old('firstname', $info->firstname) }}">
    </div>

    <div class="col-md-4">
        <h5>Middle Name</h5>
        <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="{{ Input::old('middlename', $info->middlename) }}">
    </div>

    <div class="col-md-4">
        <h5>Last Name</h5>
        <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="{{ Input::old('lastname', $info->lastname) }}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>Employee ID</h5>
        <input type="text" class="form-control" name="employee_id" placeholder="Employee ID" value="{{ Input::old('employee_id', $info->employee_id) }}">
    </div>
    <div class="col-md-4">
        <h5>Birth Date</h5>
        <input type="text" class="form-control datepicker" name="birth_date" placeholder="Birth Date" value="{{ Input::old('birth_date', $info->birth_date) }}">
    </div>
    <div class="col-md-4">
        <h5>Birth Place</h5>
        <input type="text" class="form-control" name="birth_place" placeholder="Birth Place" value="{{ Input::old('birth_place', $info->birth_place) }}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>Gender</h5>
        {{ Form::select('gender', ['' => 'Select Gender'] + genders(), Input::old('gender', $info->gender), ['class' => 'form-control select2'] )  }}
    </div>

    <div class="col-md-4">
    <h5>Citizenship</h5>
        <input type="text" class="form-control" name="citizenship" placeholder="Citizenship" value="{{ Input::old('citizenship', $info->citizenship) }}">
    </div>

    <div class="col-md-4">
        <h5>Civil Status</h5>
        {{ Form::select('civil_status', ['' => 'Select Civil Status'] + civil_status(), Input::old('civil_status', $info->civil_status), ['class' => 'form-control select2'] )  }}
    </div>
</div>

<hr>

<h5 class="uppercase sbold text-primary">Address</h5>

<div class="form-group">
    <div class="col-md-4">
        <h5>Street Address</h5>
        <input type="text" class="form-control" name="street_address" placeholder="Street Address" value="{{ Input::old('street_address', $info->street_address) }}">
    </div>

    <div class="col-md-4">
        <h5>Apartment, suite, unit, etc.</h5>
        <input type="text" class="form-control" name="address_2" placeholder="Apartment, suite, unit, etc." value="{{ Input::old('address_2', $info->address_2) }}">
    </div>

    <div class="col-md-4">
        <h5>Town / City</h5>
        <input type="text" class="form-control" name="city" placeholder="Town / City" value="{{ Input::old('city', $info->city) }}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        <h5>State / Province</h5>
        <input type="text" class="form-control" name="state" placeholder="State / Province" value="{{ Input::old('state', $info->state) }}">
    </div>

    <div class="col-md-4">
    <h5>Zip Code</h5>
        <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" value="{{ Input::old('zip_code', $info->zip_code) }}">
    </div>

    <div class="col-md-4">
        <h5>Country</h5>
        {{ Form::select('country', ['' => 'Select Country'] + countries(), Input::old('country', $info->country), ['class' => 'form-control select2'] )  }}
    </div>
</div>

<hr>

<h5 class="uppercase sbold text-primary">Contact Details</h5>

<div class="form-group">
    <div class="col-md-4">
    <h5>Telephone Number</h5>
        <input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number" value="{{ Input::old('telephone_number', $info->telephone_number) }}">
    </div>

    <div class="col-md-4">
        <h5>Mobile Number</h5>
        <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" value="{{ Input::old('mobile_number', $info->mobile_number) }}">
    </div>

    <div class="col-md-4">
        <h5>Email Address</h5>
        <input type="text" class="form-control" name="email" placeholder="Email Address" value="{{ Input::old('email', $info->email) }}">
    </div>
</div>


