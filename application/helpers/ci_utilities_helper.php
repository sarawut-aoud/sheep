<?php
function insert_csrf_field($return = false)
{
	$CI = &get_instance();
	$csrf = array(
		'name' => $CI->security->get_csrf_token_name(),
		'hash' => $CI->security->get_csrf_hash()
	);
	$input = '<input type="hidden" name="' . $csrf['name'] . '" value="' . $csrf['hash'] . '" />';
	if ($return == true) {
		return $input;
	} else {
		echo $input;
	}
}

function addTabs($num)
{
	return str_repeat("\t", $num);
}

function set_single_qoute($field_type)
{
	$string = '';
	if ($field_type != 'int' && $field_type != 'float' && $field_type != 'double') {
		$string = "'";
	}
	return $string;
}

function isTime($time)
{
	if (strlen($time) == 5) {
		return preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $time);
	} elseif (strlen($time) == 8) {
		return preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}#", $time);
	}
	return false;
}

function getTimeFromDate($date)
{
	if ($date != '') {
		$dte = $arrDate = explode(" ", $date);
		if (isset($dte[1])) {
			return $dte[1];
		}
	}
}

function setDateFormat($date)
{ //สร้างรูปแบบของวันที่ yyyy-mm-dd
	$y = '';
	$m = '';
	$d = '';
	if ($date != '') {
		//ZAN@2017-06-20
		$dte = $arrDate = explode(" ", $date);
		$date = $dte[0];
		if (preg_match("/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/", $date, $arr) || preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $date, $arr)) {
			//ถ้าเป็น xx-xx-yyyy หรือ xx/xx/yyyy
			$y = $arr[3];
			$m = sprintf("%02d", $arr[2]);
			$d = sprintf("%02d", $arr[1]);
		} else if (preg_match("/^([0-9]{4})\-([0-9]{1,2})\-([0-9]{1,2})$/", $date, $arr) || preg_match("/^([0-9]{4})\/([0-9]{1,2})\/([0-9]{1,2})$/", $date, $arr)) {
			//ถ้าเป็น yyyy-xx-xx หรือ yyyy/xx/xx
			$y = $arr[1];
			$m = sprintf("%02d", $arr[2]);
			$d = sprintf("%02d", $arr[3]);
		}
	}
	if (($y != "" && $m != "" && $d != "") and ($y != '0000' && $m != '00' && $d != '00')) {
		return $y . "-" . $m . "-" . $d; //คืนค่า ปี-เดือน-วัน
	} else {
		return $date;
	}
}

// DD/MM/YYYY+543 ??:??:??
function setDateToThai($date, $time = true, $style = '', $check_zero_day = true)
{
	if ($date == '') return $date;
	$arr    = explode(' ', $date);
	if ($time == true) {
		$time = isset($arr[1]) ? ' ' . $arr[1] : '';
	} else {
		$time = '';
	}

	$new_format = setDateFormat($arr[0]);
	$dte    = explode('-', $new_format);
	$y      = (isset($dte[0]) && $dte[0] > 0) ? $dte[0] + 543 : '-';
	$m      = isset($dte[1]) ? $dte[1] : '-';
	$d      = isset($dte[2]) ? (($check_zero_day) ? $dte[2] : intval($dte[2])) : '-';

	switch ($style) {
		case 'full_month':
			$full = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
			$month = $full[$m + 0];
			$thaiDate = $d . ' ' . $month . ' ' . $y . $time;
			break;
		case 'short_month':
			$short = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
			$month = $short[$m + 0];
			$thaiDate = $d . ' ' . $month . ' ' . $y . $time;
			break;
		case 'short_date':
			$thaiDate = $d . '-' . $m . '-' . $y;
			$thaiDate = date("d-M-Y", strtotime($thaiDate));
			break;
		default:
			$thaiDate = $d . '/' . $m . '/' . $y . $time;
			break;
	}
	return $thaiDate;
}

function setThaiDateFullMonth($date, $time = true)
{
	return setDateToThai($date, $time, 'full_month');
}

function setThaiDateShortMonth($date, $time = true)
{
	return setDateToThai($date, $time, 'short_month');
}

function setThaiDate($date, $time = true)
{
	return setDateToThai($date, $time);
}

function setThaiShortDate($date, $time = true)
{
	return setDateToThai($date, $time, 'short_date');
}

function setDateToBirthday($date, $time = true)
{
	if ($date == '') return $date;
	$dateA = explode(' ', $date);
	$time   = isset($dateA[1]) ? ' ' . $dateA[1] : '';

	$new_format = setDateFormat($dateA[0]);
	$arrD   = explode('-', $new_format);
	$y      = (isset($arrD[0]) && $arrD[0] > 0) ? $arrD[0] : $arrD[0];
	$m      = isset($arrD[1]) ? $arrD[1] : '/';
	$d      = isset($arrD[2]) ? $arrD[2] : '/';
	return $y . '-' . $m . '-' . $d;
}


// YYYY-MM-DD ??:??:??
function setDateToStandard($date, $time = true)
{
	if ($date == '') return $date;
	$dateA = explode(' ', $date);
	$time   = isset($dateA[1]) ? ' ' . $dateA[1] : '';

	$new_format = setDateFormat($dateA[0]);
	$arrD   = explode('-', $new_format);
	$y      = (isset($arrD[0]) && $arrD[0] > 0) ? $arrD[0] - 543 : $arrD[0];
	$m      = isset($arrD[1]) ? $arrD[1] : '/';
	$d      = isset($arrD[2]) ? $arrD[2] : '/';
	return $y . '-' . $m . '-' . $d . $time;
}

// Set Number
function stringToNumber($val)
{
	$val = str_replace(",", "", $val);
	return floatval($val);
}


//-- Database Helper --//
function getValueAll($table, $field_value, $field_text, $where = '', $db = NULL)
{
	if ($db === NULL) {
		$CI = &get_instance();
		$db = $CI->db;
	}
	if ($where != '') $where = "WHERE " . $where;

	$sql = "SELECT $field_value, $field_text FROM $table $where";
	$qry = $db->query($sql);
	$data = array();
	foreach ($qry->result_array() as $row) {
		$data[$row[$field_value]] = $row[$field_text];
	}
	return $data;
}

function getValueOf($table, $field_select, $where = '', $db = NULL)
{
	if ($db === NULL) {
		$CI = &get_instance();
		$db = $CI->db;
	}
	if ($where != '') $where = "WHERE " . $where;
	$sql = "SELECT $field_select FROM $table $where LIMIT 1";
	$qry = $db->query($sql);
	if ($row = $qry->row_array()) {
		return $row[$field_select];
	}
}

function getRowOf($table, $field_select = '*', $where = '', $db = NULL)
{
	if ($db === NULL) {
		$CI = &get_instance();
		$db = $CI->db;
	}
	if ($where != '') $where = "WHERE " . $where;
	$sql = "SELECT $field_select FROM $table $where LIMIT 1";
	$qry = $db->query($sql);
	return $qry->row_array();
}

function optionList($table, $field_value, $field_text, $condition = array(), $db = NULL)
{
	if ($db === NULL) {
		$CI = &get_instance();
		$mydb = $CI->db;
	} else {
		$mydb = $db;
	}
	$where = '';
	if (isset($condition['where'])) {
		$where = "WHERE " . $condition['where'];
	}
	if (isset($condition['order_by'])) {
		$order_by = $condition['order_by'];
	} else {
		$order_by = $field_text;
	}

	$ret = false;
	if (isset($condition['return'])) {
		$ret = $condition['return'];
	}

	$select_value = '';
	if (isset($condition['active'])) {
		$select_value = $condition['active'];
	}

	$list = '';
	$order_by = 'ORDER BY ' . $order_by;
	$sql = "SELECT $field_value, $field_text FROM $table $where $order_by";
	$qry = $mydb->query($sql);
	foreach ($qry->result_array() as $row) {
		$selected = '';
		if ($select_value == $row[$field_value]) {
			$selected = 'selected="selected"';
		}
		$option = '<option value="' . $row[$field_value] . '" ' . $selected . '>' . $row[$field_text] . '</option>';
		if ($ret == true) {
			$list .= $option;
		} else {
			echo $option;
		}
	}

	if ($ret == true) {
		return $list;
	}
}

function dump($data)
{
	echo '<pre>', print_r($data, TRUE), '</pre>';
}

function my_simple_crypt($string, $action = 'e')
{
	// you may change these values to your own
	$secret_key = 'my@simple#secret-key234';
	$secret_iv = 'my@simple#secret-iv345';

	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'e') {
		$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	} else if ($action == 'd') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

function encrypt($string)
{
	$salting = substr(md5(microtime()), -1) . $string;
	return my_simple_crypt($salting, 'e');
}

function decrypt($string)
{
	$encode = my_simple_crypt($string, 'd');
	return substr($encode, 1);
}

function ci_encrypt($string)
{
	return my_simple_crypt($string, 'e');
}

function ci_decrypt($string)
{
	return my_simple_crypt($string, 'd');
}

function checkEncryptData($value)
{
	$check_id = decrypt($value); //ถ้าถอดรหัสมาก่อนแล้ว จะกลายเป็นค่าว่าง
	if ($check_id != '') {
		$value = $check_id;         //ถ้าไม่เป็นค่าว่าง แสดงว่าก่อนหน้านี้ยังเข้ารหัสอยู่ ให้ใช้ค่าที่ถอดรหัสแล้ว
	}
	return $value;
}

/**
 * Call md5() with salting
 * @param String $input_pass from user register
 * @return String a 32-character hexadecimal number
 */
function encrypt_md5_salt($input_pass)
{
	// 123456 ($2y$11$7E1Dw5fgB1FifW0apMj8meNHQG9janZMxtnaWPC4niyulskCov5sa)
	$key1 = 'RTy4$58/*tdr#t';	//default = RTy4$58/*tdr#t
	$key2 = 'ci@gen#$_sdf';		//default = ci@gen#$_sdf

	$key_md5 = md5($key1 . $input_pass . $key2);
	$key_md5 = md5($key2 . $key_md5 . $key1);
	$sub1 = substr($key_md5, 0, 7);
	$sub2 = substr($key_md5, 7, 10);
	$sub3 = substr($key_md5, 17, 12);
	$sub4 = substr($key_md5, 29, 3);
	return md5($sub3 . $sub1 . $sub4 . $sub2);
}

/**
 * Call password_hash() with md5 + salting
 * @param String $input_pass from user register
 * @return String always be a 60 character string
 */
function pass_secure_hash($input_pass)
{
	$encrypt_pass = encrypt_md5_salt($input_pass);
	$options = array('cost' => 11);
	return password_hash($encrypt_pass, PASSWORD_BCRYPT, $options);
}

/**
 * Call password_verify() with md5 + salting
 * @param String $input_pass from user Login
 * @param String $record_password from database user record
 * @return Boolean 
 */
function pass_secure_verify($input_pass, $record_password)
{
	$encrypt_pass = encrypt_md5_salt($input_pass);
	return password_verify($encrypt_pass, $record_password);
}



//check language
if (!function_exists('check_lang')) {
	function check_lang()
	{
		$CI = &get_instance();
		if ($CI->input->get('lang') and ($CI->input->get('lang') == 'th' || $CI->input->get('lang') == 'en' || $CI->input->get('lang') == 'jp')) {
			$CI->session->set_userdata('language', $CI->input->get('lang'));
		}

		if (!$CI->session->userdata('language')) {
			$CI->session->set_userdata('language', 'th');
			redirect(current_url());
		} else {
			switch ($CI->session->userdata('language')) {
				case 'th':
					$CI->lang->load('pages', 'thai');
					break;
				case 'en':
					$CI->lang->load('pages', 'english');
					break;
				case 'jp':
					$CI->lang->load('pages', 'japanese');
					break;
			}
		}
	}
}


function timeToSeconds(string $time): int
{
	$arr = explode(':', $time);
	if (count($arr) === 3) {
		return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
	}
	return $arr[0] * 60 + $arr[1];
}

function cal_off($opater = null)
{
	$result = "";

	foreach ($opater as $key => $value) {
		$temp1 = $value['num1'];
		$temp2 = $value['ope1'];
		$temp3 = $value['num2'];
		$temp4 = $value['ope2'];
		$temp5 = $value['num3'];
		$c = eval("return $temp1 $temp2 $temp3;");
		$r = eval("return $c $temp4 $temp5;");
		//   print_r("<br>" . '(' . $temp1 . $temp2 . $temp3 . ')' .$temp4 . $temp5);        
		//   print_r(" result = " . $r);          

		$result = ($value['res'] == "") ? (($r == false) ? "0.00" : $r) : ($r == false ? '0.00' : $value['res']);
		if (!($r === false) || $r) {
			return $result;
		}
	}

	return $result;
}

function betweenDates($cmpDate, $startDate, $endDate)
{
	return (date($cmpDate) > date($startDate)) && (date($cmpDate) < date($endDate));
}

function monthDateDiff($strStartDate, $strEndDate)
{
	$intWorkDay = 0;
	$intHoliday = 0;
	$intTotalDay = ((strtotime($strEndDate) - strtotime($strStartDate)) /  (60 * 60 * 24)) + 1;
	$intTotalDayDeduct = ((strtotime($strEndDate) - strtotime($strStartDate)) /  (60 * 60 * 24)) + 1;

	if (date('d', strtotime($strStartDate)) == 31) {
		$intTotalDayDeduct = $intTotalDay - 1;
	} else if (date('m', strtotime($strStartDate)) == 2 && date('d', strtotime($strStartDate)) == 28) {
		$intTotalDayDeduct = $intTotalDayDeduct + 2;
	} else if (date('m', strtotime($strStartDate)) == 2 && date('d', strtotime($strStartDate)) == 29) {
		$intTotalDayDeduct = $intTotalDayDeduct + 1;
	} else if (date('d', strtotime($strEndDate)) == 31) {
		$intTotalDayDeduct = $intTotalDayDeduct - 1;
	} else if (date('m', strtotime($strEndDate)) == 2 && date('d', strtotime($strEndDate)) == 28) {
		$intTotalDayDeduct = $intTotalDayDeduct + 2;
	} else if (date('m', strtotime($strEndDate)) == 2 && date('d', strtotime($strEndDate)) == 29) {
		$intTotalDayDeduct = $intTotalDayDeduct + 1;
	} else if (date('m', strtotime($strStartDate)) == 2 && $intTotalDayDeduct < 30) {
		if ($intTotalDayDeduct == 28) {
			$intTotalDayDeduct = $intTotalDayDeduct + 2;
		} else if ($intTotalDayDeduct == 29) {
			$intTotalDayDeduct = $intTotalDayDeduct + 1;
		}
	}
	if ($intTotalDayDeduct > 30) {
		$intTotalDayDeduct = 30;
	}

	while (strtotime($strStartDate) <= strtotime($strEndDate)) {

		$DayOfWeek = date("w", strtotime($strStartDate));
		if ($DayOfWeek == 0 or $DayOfWeek == 6)  // 0 = Sunday, 6 = Saturday;
		{
			$intHoliday++;
			// echo "$strStartDate = <font color=red>Holiday</font><br>";
		} else {
			$intWorkDay++;
			// echo "$strStartDate = <b>Work Day</b><br>";
		}
		//$DayOfWeek = date("l", strtotime($strStartDate)); // return Sunday, Monday,Tuesday....

		$strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
	}
	$allday = array('total' => $intTotalDay, 'work' => $intWorkDay, 'holiday' => $intHoliday, 'daydeduct' => $intTotalDayDeduct);

	return $allday;
}

function convertDateSave($date)
{
	return date('Y-m-d', strtotime($date));
};







function HTMLToRGB($htmlCode)
{
	if ($htmlCode[0] == '#')
		$htmlCode = substr($htmlCode, 1);

	if (strlen($htmlCode) == 3) {
		$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
	}

	$r = hexdec($htmlCode[0] . $htmlCode[1]);
	$g = hexdec($htmlCode[2] . $htmlCode[3]);
	$b = hexdec($htmlCode[4] . $htmlCode[5]);

	return $b + ($g << 0x8) + ($r << 0x10);
}

function RGBToHSL($RGB)
{
	$r = 0xFF & ($RGB >> 0x10);
	$g = 0xFF & ($RGB >> 0x8);
	$b = 0xFF & $RGB;

	$r = ((float)$r) / 255.0;
	$g = ((float)$g) / 255.0;
	$b = ((float)$b) / 255.0;

	$maxC = max($r, $g, $b);
	$minC = min($r, $g, $b);

	$l = ($maxC + $minC) / 2.0;

	if ($maxC == $minC) {
		$s = 0;
		$h = 0;
	} else {
		if ($l < .5) {
			$s = ($maxC - $minC) / ($maxC + $minC);
		} else {
			$s = ($maxC - $minC) / (2.0 - $maxC - $minC);
		}
		if ($r == $maxC)
			$h = ($g - $b) / ($maxC - $minC);
		if ($g == $maxC)
			$h = 2.0 + ($b - $r) / ($maxC - $minC);
		if ($b == $maxC)
			$h = 4.0 + ($r - $g) / ($maxC - $minC);

		$h = $h / 6.0;
	}

	$h = (int)round(255.0 * $h);
	$s = (int)round(255.0 * $s);
	$l = (int)round(255.0 * $l);

	return (object) array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
}
function DateThai($strDate, $type = null)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strMonthCut = array(
		"",
		"มกราคม",
		"กุมภาพันธ์",
		"มีนาคม",
		"เมษายน",
		"พฤษภาคม",
		"มิถุนายน",
		"กรกฎาคม",
		"สิงหาคม",
		"กันยายน",
		"ตุลาคม",
		"พฤศจิกายน",
		"ธันวาคม",
	);
	$strMonthThai = $strMonthCut[$strMonth];

	if ($type == NULL) {
		return "$strDay $strMonthThai $strYear";
	} else if ($type == 'Y' || $type == 'y') {
		return "$strYear";
	} else if ($type == 'M' || $type == 'm') {
		return "$strMonthThai";
	} else if ($type == 'D' || $type == 'd') {
		return "$strDay";
	}
}
