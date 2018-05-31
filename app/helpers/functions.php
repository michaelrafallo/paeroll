<?php

function is_plural($string) {
  return ($string > 1) ? 's' : '';
}

//----------------------------------------------------------------

function ordinal($num) {
  if (!in_array(($num % 100),array(11,12,13))){
    switch ($num % 10) {
      // Handle 1st, 2nd, 3rd
      case 1:  return $num.'st';
      case 2:  return $num.'nd';
      case 3:  return $num.'rd';
    }
  }
  return $num.'th';
}

//----------------------------------------------------------------

function get_cc_months($val ='') {
  
  foreach (range(1, 12) as $month) {
    $m =sprintf('%02d', $month);
    $data[$m] = getMonths($m); 
   } 

  return ($val) ? $data[$val] : $data;
} 

//----------------------------------------------------------------

function get_cc_years($val ='') {
  
  foreach (range(date('Y'), date('Y')+7) as $year) {
    $data[$year] = $year; 
   } 

  return ($val) ? $data[$val] : $data;
} 

//----------------------------------------------------------------


function code_to_text($val ='') {
  return ucwords(str_replace('_', ' ', $val));  
}

//----------------------------------------------------------------

function stars_review($count = 0) {
  $star = '';
  
  if($count) {
    $c = explode('.', $count);
    foreach(range(1, $c[0]) as $s) {
      $star .= '<i class="fa fa-star"></i> ';  
    }

    if(@$c[1]) $star .= '<i class="fa fa-star-half"></i> ';   
  }

  echo $star;
}

//----------------------------------------------------------------

function array_val_formatted($key, $val) {
  
  $data = '';

  $file = [
    "profile_picture",
    "proof_of_insurance"
  ];

  $hidden = ['facebook_access_token'];

  $is_numeric = ['exemption_amount', 'exemption_rate', 'excess'];

  if( in_array($key, $hidden) ) {
    return false;
  }

  if( in_array($key, $file) ) {
    $data = '';
  }  elseif( $key == 'payroll_period' ) {
    $data = payroll_period($val);
  } elseif( $key == 'tax_status' ) {
    $data = tax_status($val);
  } elseif( $key == 'civil_status' ) {
    $data = civil_status($val);
  }  elseif( in_array($key, $is_numeric) ) {
      $data = number_format($val, 2);
  } else {
    $data = $val;
  }

  return $data;
}

//----------------------------------------------------------------

function basic_pay($info = '', $period = 15) {

  $data = [
    '1'  => @$info->daily_rate,
    '7'  => @$info->daily_rate * 7,
    '15' => @$info->monthly_rate / 2,
    '30' => @$info->monthly_rate,
  ];

  return $data[$period];
}

//----------------------------------------------------------------

function editFile($file, $key, $value, $seperator ='=') {
  $fh = fopen($file,'r+');
  // string to put username and passwords
  $i=1;
  $contents = '';
  while(!feof($fh)) {
    $user = explode($seperator,fgets($fh));

    // take-off old "\r\n"
    $file_key = @trim($user[0]);
    $file_val = @trim($user[1]);
    // check for empty indexes

    if($i == 1) {
      $contents .= "TIMEZONE" . '=' . "$value\n";       
    }

    if ($file_key == $key) {
        $file_val = ""; 
    }

    if (!empty($file_key) AND !empty($file_val)) {
        $contents .= $file_key . $seperator . $file_val;
        $contents .= "\n";
    }
    if($file_key == '') {
        $contents .= "\n";
    }
    $i++;
   }

  // using file_put_contents() instead of fwrite()
  file_put_contents($file, $contents);
  fclose($fh);  
}

//----------------------------------------------------------------

function selected($val, $post) {
  return ($val == $post) ? 'selected="selected"' : '';  
}

//----------------------------------------------------------------

function actived($val, $post) {
  return ($val == $post) ? 'active' : ''; 
}

//----------------------------------------------------------------

function checked($val, $post) {
  return ($val == $post) ? 'checked="checked"' : '';  
}

//----------------------------------------------------------------

function status($val ='') {
  return ($val == 1) ? 'Active' : 'Inactive'; 
}

//----------------------------------------------------------------

function time_zone($val='') {

  $timezone = (array)json_decode(file_get_contents('data/timezone.json'));

  if( $val ) {
      foreach($timezone as $s) {
        foreach($s as $k => $v) {
          $data[$k] = $v;
        }
      }
    return $data[$val];
  } else {
    foreach($timezone as $k => $v) {
      $data[$k] = (array)$v;
    }

    return $data;
  }
}

//----------------------------------------------------------------

function sort_array_multidim(array $array, $order_by) {
    //TODO -c flexibility -o tufanbarisyildirim : this error can be deleted if you want to sort as sql like "NULL LAST/FIRST" behavior.
    if(!is_array($array[0]))
        throw new Exception('$array must be a multidimensional array!',E_USER_ERROR);
    $columns = explode(',',$order_by);
    foreach ($columns as $col_dir)
    {
        if(preg_match('/(.*)([\s]+)(ASC|DESC)/is',$col_dir,$matches))
        {
            if(!array_key_exists(trim($matches[1]),$array[0]))
                trigger_error('Unknown Column <b>' . trim($matches[1]) . '</b>',E_USER_NOTICE);
            else
            {
                if(isset($sorts[trim($matches[1])]))
                    trigger_error('Redundand specified column name : <b>' . trim($matches[1] . '</b>'));
                $sorts[trim($matches[1])] = 'SORT_'.strtoupper(trim($matches[3]));
            }
        }
        else
        {
            throw new Exception("Incorrect syntax near : '{$col_dir}'",E_USER_ERROR);
        }
    }
    //TODO -c optimization -o tufanbarisyildirim : use array_* functions.
    $colarr = array();
    foreach ($sorts as $col => $order)
    {
        $colarr[$col] = array();
        foreach ($array as $k => $row)
        {
            $colarr[$col]['_'.$k] = strtolower($row[$col]);
        }
    }
   
    $multi_params = array();
    foreach ($sorts as $col => $order)
    {
        $multi_params[] = '$colarr[\'' . $col .'\']';
        $multi_params[] = $order;
    }
    $rum_params = implode(',',$multi_params);
    eval("array_multisort({$rum_params});");
    $sorted_array = array();
    foreach ($colarr as $col => $arr)
    {
        foreach ($arr as $k => $v)
        {
            $k = substr($k,1);
            if (!isset($sorted_array[$k]))
                $sorted_array[$k] = $array[$k];
            $sorted_array[$k][$col] = $array[$k][$col];
        }
    }
    return array_values($sorted_array);
}

//----------------------------------------------------------------

function has_photo($path ='') {
  if($path) {
    if( file_exists($path) ) {
      return asset($path);    
    }
  }
  // Default
  return asset('img/avatar.png');
}

//----------------------------------------------------------------

function date_formatted($date ='') {  
  if( $date == '' || $date == '0000-00-00' || $date == '1970-01-01') return '';
  if (preg_match("/\d{4}\-\d{2}-\d{2}/", $date)) {
      return date('d-M-Y', strtotime($date));
  } else {
      return date('Y-m-d', strtotime($date));
  }
}

//----------------------------------------------------------------

function date_formatted_b($date ='') {  
  if( $date == '' || $date == '0000-00-00' || $date == '1970-01-01') return '';

  if (preg_match("/\d{4}\-\d{2}-\d{2}/", $date)) {
      return date('m-d-Y', strtotime($date));
  } else {
      list($m, $d, $y) = explode('-', $date);
      return $y.'-'.$m.'-'.$d;
  }
}

//----------------------------------------------------------------

function name_formatted($user_id, $format = 'l, f') { 
  $d = App\User::find($user_id);

  $split_format = str_split($format);
  $name ='';
  foreach ($split_format as $char) {
    
    if (preg_match('/[a-zA-Z]/', $char)) {
      $n = ($char == 'l') ? 'lastname' : 'firstname';
      $name .= @$d->$n;
    } else {
      $name .= $char;
    }
  }
  
  return ucwords($name);
}

//----------------------------------------------------------------

function amount_formatted($amount) {
  return currency_symbol('PHP').' '.number_format($amount, 2);
}

//----------------------------------------------------------------

function currency_symbol( $currency = '' ) {
  if ( ! $currency ) {
    $currency = get_woocommerce_currency();
  }

  switch ( $currency ) {
    case 'AED' :
      $currency_symbol = 'د.إ';
      break;
    case 'AUD' :
    case 'ARS' :
    case 'CAD' :
    case 'CLP' :
    case 'COP' :
    case 'HKD' :
    case 'MXN' :
    case 'NZD' :
    case 'SGD' :
    case 'USD' :
      $currency_symbol = '$';
      break;
    case 'BDT':
      $currency_symbol = '৳&nbsp;';
      break;
    case 'BGN' :
      $currency_symbol = 'лв.';
      break;
    case 'BRL' :
      $currency_symbol = 'R$';
      break;
    case 'CHF' :
      $currency_symbol = 'CHF';
      break;
    case 'CNY' :
    case 'JPY' :
    case 'RMB' :
      $currency_symbol = '&yen;';
      break;
    case 'CZK' :
      $currency_symbol = 'Kč';
      break;
    case 'DKK' :
      $currency_symbol = 'DKK';
      break;
    case 'DOP' :
      $currency_symbol = 'RD$';
      break;
    case 'EGP' :
      $currency_symbol = 'EGP';
      break;
    case 'EUR' :
      $currency_symbol = '&euro;';
      break;
    case 'GBP' :
      $currency_symbol = '&pound;';
      break;
    case 'HRK' :
      $currency_symbol = 'Kn';
      break;
    case 'HUF' :
      $currency_symbol = 'Ft';
      break;
    case 'IDR' :
      $currency_symbol = 'Rp';
      break;
    case 'ILS' :
      $currency_symbol = '₪';
      break;
    case 'INR' :
      $currency_symbol = 'Rs.';
      break;
    case 'ISK' :
      $currency_symbol = 'Kr.';
      break;
    case 'KIP' :
      $currency_symbol = '₭';
      break;
    case 'KRW' :
      $currency_symbol = '₩';
      break;
    case 'MYR' :
      $currency_symbol = 'RM';
      break;
    case 'NGN' :
      $currency_symbol = '₦';
      break;
    case 'NOK' :
      $currency_symbol = 'kr';
      break;
    case 'NPR' :
      $currency_symbol = 'Rs.';
      break;
    case 'PHP' :
      $currency_symbol = '₱';
      break;
    case 'PLN' :
      $currency_symbol = 'zł';
      break;
    case 'PYG' :
      $currency_symbol = '₲';
  break;
    case 'RON' :
      $currency_symbol = 'lei';
      break;
    case 'RUB' :
      $currency_symbol = 'руб.';
      break;
    case 'SEK' :
      $currency_symbol = 'kr';
      break;
    case 'THB' :
      $currency_symbol = '฿';
      break;
    case 'TRY' :
      $currency_symbol = '₺';
      break;
    case 'TWD' :
      $currency_symbol = 'NT$';
      break;
    case 'UAH' :
      $currency_symbol = '₴';
      break;
    case 'VND' :
      $currency_symbol = '₫';
      break;
    case 'ZAR' :
      $currency_symbol = 'R';
      break;
    default :
      $currency_symbol = '';
      break;
  }

  return $currency_symbol;
}

//----------------------------------------------------------------

function time_ago($time_ago) {

    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "1 minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}

//----------------------------------------------------------------

function array_to_json($val='') {

  if( is_array($val) ) {
    $val = json_encode($val);
  }

  return $val;
}

//----------------------------------------------------------------

function text_to_slug($val='') {
  return str_replace([' ', '(',')'], ['-',''], strtolower($val));
}

//----------------------------------------------------------------

function active_form($form, $segment) {

  if($segment == $form) {
    return 'active';
  } elseif($segment > $form) {
    return 'done';
  }
}

//----------------------------------------------------------------

function query_vars($query ='') {

    $qs = $_SERVER['QUERY_STRING'];
    $vars = array();
  if($query == '') return $qs;

    parse_str($_SERVER['QUERY_STRING'], $qs);
    
    foreach ($qs as $key => $value) {     
    $vars[$key] = $value;

    if($value == '0') {
      unset($vars[$key]);   
    }
    }
 
    parse_str($query, $queries);
    
    foreach ($queries as $key => $value) {      
    $vars[$key] = $value;

    if($value == '0') {
      unset($vars[$key]);   
    }
    }

    return $vars;
}

//----------------------------------------------------------------

function get_meta($rows = array()) {
  $data = array();
  foreach($rows as $row) { 
    $data[$row->meta_key] = $row->meta_value;
  }

  return (object)$data;
}

//----------------------------------------------------------------

function user_status($val ='') {

  $data = array(
    'actived'   => 'Actived',
    "inactived" => "Inactived",
  );
  
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function per_page($val ='') {

  $data = array(
    15 => 15,
    25 => 25,
    50 => 50,
    100 => 100,
  );
  
  return ($val) ? $data[$val] : $data;
}

//----------------------------------------------------------------

function array_to_text($rows=array(), $type='') {
  $data = array();

  foreach($rows as $row) {

    if($type == 'practice_types') {
      $data[] = practice_types($row);
    }

  }


  return implode(', ', $data);
}

//----------------------------------------------------------------

function str_mask( $str, $start = 0, $length = null ) {
    $mask = preg_replace ( "/\S/", "*", $str );
    if( is_null ( $length )) {
        $mask = substr ( $mask, $start );
        $str = substr_replace ( $str, $mask, $start );
    }else{
        $mask = substr ( $mask, $start, $length );
        $str = substr_replace ( $str, $mask, $start, $length );
    }
    return $str;
}

//----------------------------------------------------------------

function compress($source, $destination, $quality) {

  $info = getimagesize($source);

  if ($info['mime'] == 'image/jpeg') 
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif') 
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png') 
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);

  return $destination;
}

//----------------------------------------------------------------

function cURL($url, $header=NULL, $cookie=NULL, $p=NULL) {
    $ch = curl_init();

  
  $ipku = $_SERVER['REMOTE_ADDR'];
  $ip = array("REMOTE_ADDR: $ipku", "HTTP_X_FORWARDED_FOR: $ipku");


    curl_setopt($ch, CURLOPT_HEADER, $header);
    curl_setopt($ch, CURLOPT_NOBODY, $header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_COOKIE, $cookie);

    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

  curl_setopt($ch,CURLOPT_HTTPHEADER,$ip);

  /*
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT,'Opera/9.80 (Series 60; Opera Mini/6.5.27309/34.1445; U; en) Presto/2.8.119 Version/11.10');
  */

    if ($p) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
    }
    $result = curl_exec($ch);

    curl_close($ch);

    return $result;

}

//----------------------------------------------------------------

function upload_image($file, $path, $old_file, $compress = true) {

    $filename   = str_random(16);
    $imageFile  = $file->getRealPath();
    $ext        = $file->getClientOriginalExtension();
    $path       = $path;

    if( ! file_exists($path) ) mkdir($path);

    $profile_pic = $path.'/'.$filename.'.png';  
    if( file_exists($old_file) ) unlink($old_file);

    $img = \Image::make($imageFile)->resize(230, '', function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    })->save($profile_pic);

    if($compress) {
      compress($profile_pic, $profile_pic, 70);
    }

    return $profile_pic;
}

//----------------------------------------------------------------

function pay_period() {
  list($m, $d, $y) = explode('-', $this->setting->get_setting('last_cut_off'));
  $last_cut_off =  $y.'-'.$m.'-'.$d;

  $pay_day  = $this->setting->get_setting('pay_day');

  echo date('Y-m-d', strtotime($pay_day.' days', strtotime($last_cut_off) ));
  echo date('Y-m-d', strtotime($pay_day.' days', strtotime($last_cut_off) ));
}

//----------------------------------------------------------------

function tax_exemption($status, $dependent = 0, $code = false) {    

    $data = civil_status($status).' w/ '.$dependent.' dependent'.is_plural($dependent);

    if( $code ) {
        $data = ($status=='single' ? 'S' : 'ME') . ($dependent ? $dependent : '');
    }

    return $data;
}

function get_days_diff($date_start ='', $date_end ='') {
  $date_start = date_formatted_b($date_start);
  $date_end = date_formatted_b($date_end);
  $days = (strtotime($date_end) - strtotime($date_start)) / (60 * 60 * 24);

  return $days == 0 ? 1 : $days + 1;
}
  