<?php
function getMonths($val ='') {
 
	$data = array(
		"01" => "January",
		"02" => "February",
		"03" => "March",
		"04" => "April",
		"05" => "May",
		"06" => "June",
		"07" => "July",
		"08" => "August",
		"09" => "September",
		"10" => "October",
		"11" => "November",
		"12" => "December"
	);

	return ($val) ? $data[$val] : $data;
} 

//----------------------------------------------------------------

function civil_status($val ='') {

  $data = array(
    'single'   => 'Single',
    'married'  => 'Married',
    'divorced' => 'Divorced',
    'widowed ' => 'Widowed ',
  );
  
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function tax_status($val ='') {

  $data = array(
    '0'        => 'Zero Exemption',
    'single'   => 'Single',
    'married'  => 'Married',
  );
  
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function genders($val ='') {

	$data['male'] = 'Male';
	$data['female'] = 'Female';

	return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function countries($val ='') {
	$data = (array)json_decode(file_get_contents('data/countries.json'));
	return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function job_type($val='') {
	$data = [
		'full_time' => 'Full time',
		'part_time' => 'Part time',
		'temporary' => 'Temporary',
	];

	return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function leave_type($val='') {
  $data = [
    'requested' => 'Requested',
    'approved'  => 'Approved',
    'cancelled' => 'Cancelled',
  ];

  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function placement($val='') {
	$data = [
		'permanent' => 'Permanent',
		'temporary' => 'Temporary',
	];

	return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function salary_type($val='') {
	$data = [
		'annual' => 'Annual salary',
		'hourly' => 'Hourly',
	];

	return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function form_actions($val ='') {
 
	$data = array(
		"trash" => "Move to Trash",
	);

	if( Input::get('type') ) {
		$data = array(
			"restore" => "Restore",
			"destroy" => "Delete Permanently",
		);
	}

	return ($val) ? $data[$val] : $data;
} 

//----------------------------------------------------------------

function order_by($val ='') {

  $data = array(
    'DESC' => 'Descending', 
    'ASC' => 'Ascending',
  );

  return ($val) ? @$data[$val] : $data;
}

//----------------------------------------------------------------

function user_sort_by($val ='') {

  $data = array(
    'fullname' => 'Name',
    'id' => 'ID', 
  );

  return ($val) ? @$data[$val] : $data;
}

//----------------------------------------------------------------

function user_languages($val='') {
	$languages = json_decode(file_get_contents('data/languages.json'));

	foreach($languages as $lang) {
		$data[$lang->code] = $lang->name;
	}

	return ($val) ? @$data[$val] : $data;
}

//----------------------------------------------------------------

function get_times($val='') {

	$data = json_decode(file_get_contents('data/times.json'));

	return ($val) ? @$data[$val] : $data;
}

//----------------------------------------------------------------

function status_ico($val) {
	$data['approved'] = '<span class="badge badge-primary uppercase sbold">Approved</span>';
	$data['publish'] = '<span class="badge badge-primary uppercase sbold">Published</span>';
	$data['completed'] = '<span class="badge badge-primary uppercase sbold">Completed</span>';
	$data['pending'] = '<span class="badge badge-danger uppercase sbold">Pending</span>';
	$data["cancelled"] = '<span class="badge badge-default uppercase sbold">Cancelled</span>';
	$data['unprocessed'] = '<span class="badge badge-danger uppercase sbold">Unprocessed</span>';
	$data["processing"] = '<span class="badge badge-warning uppercase sbold">Processing</span>';
	$data['processed'] = '<span class="badge badge-primary uppercase sbold">Processed</span>';
	$data['requested'] = '<span class="label badge-danger uppercase sbold">Requested</span>';
	$data["approved"]  = '<span class="label badge-primary uppercase sbold">Approved</span>';
	$data['cancelled'] = '<span class="label badge-default uppercase sbold">Cancelled</span>';
	$data['failed'] = '<span class="badge badge-default uppercase sbold">Failed</span>';
	$data["paid"]  = '<span class="badge badge-primary uppercase sbold">Paid</span>';
	$data["unpaid"] = '<span class="badge badge-default uppercase sbold">Unpaid</span>';
	$data["actived"] = '<span class="badge badge-primary uppercase sbold">Actived</span>';
	$data["inactived"] = '<span class="badge badge-default uppercase sbold">Inactived</span>';
	$data["waiting"] = '<span class="badge badge-warning uppercase sbold">Waiting</span>';
	$data["sending"] = '<span class="badge badge-warning uppercase sbold">Sending</span>';
	$data['sent']    = '<span class="badge badge-primary uppercase sbold">Sent</span>';
	$data['draft']  = '<span class="badge badge-success uppercase sbold">Draft</span>';
	$data["YES"] = '<span class="badge badge-info uppercase sbold">YES</span>';
	$data['NO']  = '<span class="badge badge-danger uppercase sbold">NO</span>';
	$data["paid"] = '<span class="badge badge-primary uppercase sbold">Paid</span>';
	$data["ended_immediately"] = '<span>Ended immediately</span>';
	$data["ended_at_period_end"] = '<span>Ended at period end</span>';
	
	echo $data[$val];
}

//----------------------------------------------------------------

function get_types($key ='', $val='') {
	$data = array(
	    "job-type" => array(
	      "label"  => "Job Types",
	      "single" => "Job Type",
	    ),
			"position" => array(
	      "label"  => "Positions",
	      "single" => "Position",
	    ),
	    "department" => array(
	      "label"  => "Departments",
	      "single" => "Department",
	    ),
	    "shift" => array(
	      "label"  => "Shifts",
	      "single" => "Shift",
	    ),
	    "earning" => array(
	      "label"  => "Earnings",
	      "single" => "Earning",
	    ),
	);

	return ($key) ? $data[$key][$val] : $data;
}

//----------------------------------------------------------------

function get_earning_types($key ='', $val='') {
  $data = array(
    "holiday" => array(
      "label"  => "Holidays",
      "single" => "Holiday",
    ),
    "overtime" => array(
      "label"  => "Overtimes",
      "single" => "Overtime",
    ),
    "night" => array(
      "label"  => "Night Differencials",
      "single" => "Night Differencial",
    )
  );

  return ($key) ? $data[$key][$val] : $data;
}

//----------------------------------------------------------------

function payroll_status($val ='') {
	$data = array(
		"unprocessed" => "Unprocessed",
		"processing"  => "Processing",
		"processed"   => "Processed",
	);
  
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function payroll_preparation($val ='') {
  $data = array(
    "10 days"  => "10 days",
    "8 days"  => "9 days",
    "8 days"  => "8 days",
    "7 days"  => "7 days",
    "6 days"  => "6 days",
    "5 days"  => "5 days",
    "4 days"  => "4 days",
    "3 days"  => "3 days",
    "2 days"  => "2 days",
    "1 day"   => "1 day",
  );
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function payroll_period($val ='') {
  $data = array(
    '1'  => "Daily",
    '7'  => "Weekly",
    '15' => "Semi-Monthly",
    '30' => "Monthly",
  );
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function user_group($val ='') {
 
	$data = array(
		"admin" => "Admin",
		"user" => "User",
	);

	return ($val) ? $data[$val] : $data;
} 

//----------------------------------------------------------------
