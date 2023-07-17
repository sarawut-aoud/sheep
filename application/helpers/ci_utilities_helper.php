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

//Get file icon
function getFileIcon($file_path)
{
	$icon = 'noimage.gif';
	if (file_exists($file_path)) {
		switch (mime_content_type($file_path)) {
			case 'image/gif':
			case 'image/jpeg':
			case 'image/png':
			case 'image/bmp':
				$icon = 'picture.png';
				break;
			case 'application/msword':
			case 'application/vnd.ms-msword':
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
				$icon = 'word.png';
				break;
			case 'application/vnd.oasis.opendocument.text':
				$icon = 'odt.png';
				break;
			case 'application/vnd.ms-powerpoint':
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
				$icon = 'powerpoint.png';
				break;
			case 'application/vnd.ms-excel':
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				$icon = 'excel.png';
				break;
			case 'application/pdf':
				$icon = 'pdf.png';
				break;
			default:
				$icon = 'clip.png';
				break;
		}
	}
	return $icon;
}

function setAttachPreview($input_name, $file_path, $title = 'เปิดไฟล์แนบ', $show_text = FALSE)
{
	$icon = getFileIcon($file_path);
	if ($icon == 'picture.png') {
		$link = '<a class="file_link" target="_blank" title="' . $title . '" href="' . site_url('file/preview/') . ci_encrypt($file_path) . '">';
		$link .= '<img id="' . $input_name . '_preview" height="150px" src="' . base_url() . '' . $file_path . '" />';
		$link .= '</a>';
	} else {
		$link = setAttachLink($input_name, $file_path, $title, $show_text);
	}
	return $link;
}

function setAttachLink($input_name, $file_path, $title = 'เปิดไฟล์แนบ', $show_text = FALSE)
{
	$text_link = '';
	$btn_class = '';
	if ($show_text == TRUE) {
		$text_link = '&nbsp; ' . $title;
		$btn_class = ' btn btn-warning';
	}

	$icon = getFileIcon($file_path);
	if ($icon != 'file_not_found.png') {

		$link = '<a class="file_link' . $btn_class . '" target="_blank" title="' . $title . '" href="' . site_url('file/preview/') . ci_encrypt($file_path) . '">';
		$link .= '<img id="' . $input_name . '_preview" class="link-file-attach" height="80"  src="' . base_url() . 'assets/images/icon/' . $icon . '" />' . $text_link;
		$link .= '</a>';
	} else {
		$link = '<a href="javascript:alert(\'ไม่พบไฟล์แนบ\')">';
		$link .= '<img id="' . $input_name . '_preview" class="link-file-attach" height="80" src="' . base_url() . 'assets/images/icon/' . $icon . '" />';
		$link .= '</a>';
	}
	return $link;
}

function setAttachLinkText($input_name, $file_path, $title = 'เปิดไฟล์แนบ')
{
	return setAttachLink($input_name, $file_path, $title, TRUE);
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
//extract array
function resultarray($array1, $explode_array)
{
	$array2 = explode(',', $explode_array);
	$array = array();

	for ($i = 0; $i < count($array2); $i++) {
		$array[] = '<span class="mb-1 g-chip g-chip-small info">' . $array1[$array2[$i]] . '</span>';
	}

	return implode(' ', $array);
}

//status
function switchstatusshow($status_approve = null, $c_class = null)
{  // function to switch status
	$status = '';
	switch ($status_approve) {
		case "approve":
			$status = '<img src="{base_url}assets/images/icon/approve.png"  style="height:29px" title="อนุมัติ">';
			break;
		case "reconsider":
			$status =  '<img src="{base_url}assets/images/icon/reconsider.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="ตรวจสอบอีกครั้ง">';
			break;
		case "reject":
			$status =  '<img src="{base_url}assets/images/icon/reject.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="ปฏิเสธ">';
			break;
		default:
			$status =  '<img src="{base_url}assets/images/icon/wating.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="รออนุมัติ">';
	}
	return $status;
}
//status
function switchstatusshowNew($status_approve = null, $c_class = null)
{  // function to switch status
	$status = '';
	// $status_approve = "reconsider";
	switch ($status_approve) {
		case "approve":
			$status = '<i class="fas fa-clipboard-check n-text-color--success" style="font-size: 29px" title="อนุมัติ"></i>';
			break;
		case "reconsider":
			$status = '<i class="fas fa-clipboard-check n-text-color--reconsider" style="font-size: 29px" title="อนุมัติ"></i>';
			// $status =  '<img src="{base_url}assets/images/icon/reconsider.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="ตรวจสอบอีกครั้ง">';
			break;
		case "reject":
			$status =  '<img src="{base_url}assets/images/icon/reject.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="ปฏิเสธ">';
			break;
		default:
			$status =  '<img src="{base_url}assets/images/icon/wating.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="รออนุมัติ">';
	}
	// $status =  '<img src="{base_url}assets/images/icon/reconsider.png" class="dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="' . $c_class . '" ria-expanded="false" data-bs-reference="parent" style="height:29px" title="ตรวจสอบอีกครั้ง">';
	return $status;
}
function switchstatusedit($status_approve = null, $c_class = null, $id = null, $approve_id = null, $pd_id = null)
{  // function to switch status
	$status = '';
	switch ($status_approve) {
		case "approve":
			$status = '<div class="btn-group mt-1 d-flex" role="group"><button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="app_' . $c_class . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><img src="{base_url}assets/images/icon/approve.png"  style="height:29px" title="อนุมัติ"></button>
							<div class="dropdown-menu" aria-labelledby="' . 'app_' . $c_class . '">
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="approve" href="#"><i class="fas fa-check-circle text-success fa-1x" title="ผ่าน"></i> ผ่าน</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"  data-value="reconsider" href="#"><img src="{base_url}assets/images/icon/reconsider.png" style="height:20px" title="ตรวจสอบอีกครั้ง"> ตรวจสอบอีกครั้ง</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"  data-value="reject" href="#"><img src="{base_url}assets/images/icon/reject.png" style="height:20px" title="ปฏิเสธ"> ปฏิเสธ</a>
								
							</div>
						</div>';
			break;
		case "reconsider":
			$status =  '<div class="btn-group mt-1 d-flex" role="group"><button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="rec_' . $c_class . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><img src="{base_url}assets/images/icon/reconsider.png"   style="height:29px" title="ตรวจสอบอีกครั้ง"></button>
							<div class="dropdown-menu" aria-labelledby="' . 'rec_' . $c_class . '">
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="approve" href="#"><i class="fas fa-check-circle text-success fa-1x" title="ผ่าน"></i> ผ่าน</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="reconsider" href="#"><img src="{base_url}assets/images/icon/reconsider.png" style="height:20px" title="ตรวจสอบอีกครั้ง"> ตรวจสอบอีกครั้ง</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="reject" href="#"><img src="{base_url}assets/images/icon/reject.png" style="height:20px" title="ปฏิเสธ"> ปฏิเสธ</a>
								
							</div>
						</div>';
			break;
		case "reject":
			$status =  '<div class="btn-group mt-1 d-flex" role="group"><button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="rej_' . $c_class . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><img src="{base_url}assets/images/icon/reject.png"  style="height:29px" title="ปฏิเสธ"></button>
							<div class="dropdown-menu" aria-labelledby="' . 'rej_' . $c_class . '">
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="approve" href="#"><i class="fas fa-check-circle text-success fa-1x" title="ผ่าน"></i> ผ่าน</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="reconsider" href="#"><img src="{base_url}assets/images/icon/reconsider.png" style="height:20px" title="ตรวจสอบอีกครั้ง"> ตรวจสอบอีกครั้ง</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"   data-value="reject" href="#"><img src="{base_url}assets/images/icon/reject.png" style="height:20px" title="ปฏิเสธ"> ปฏิเสธ</a>
								
							</div>
						</div>';
			break;
		default:
			$status =  '<div class="btn-group mt-1 d-flex" role="group"><button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split ' . $c_class . '" id="war_' . $c_class . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><img src="{base_url}assets/images/icon/wating.png" style="height:29px" title="รออนุมัติ"></button>
							<div class="dropdown-menu" aria-labelledby="' . 'war_' . $c_class . '">
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"    data-value="approve" href="#"><i class="fas fa-check-circle text-success fa-1x" title="ผ่าน"></i> ผ่าน</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"     data-value="reconsider" href="#"><img src="{base_url}assets/images/icon/reconsider.png" style="height:20px" title="ตรวจสอบอีกครั้ง"> ตรวจสอบอีกครั้ง</a>
								<a href="javascript:void(0);" class="dropdown-item chgstatus" data-id="' . $id . '" data-approve_id="' . $approve_id . '" data-pd_id="' . $pd_id . '"     data-value="reject" href="#"><img src="{base_url}assets/images/icon/reject.png" style="height:20px" title="ปฏิเสธ"> ปฏิเสธ</a>
								
							</div>
						</div>';
	}
	return $status;
}

//status badge windows
function switchstatusbadgeshow($status_approve = null, $c_class = null)
{  // function to switch status
	$status = '';
	switch (true) {
		case ($status_approve == "approve" || $status_approve == "Approved"):
			$status = '<span class="g-chip success ' . $c_class . '">' . lang('nav_Pass') . '</span>';
			break;
		case ($status_approve == "pending" || $status_approve == "Pending"):
			$status = '<span class="g-chip warning ' . $c_class . '">' . lang('nav_wait') . '</span>';
			break;
		case ($status_approve == "reject" || $status_approve == "Rejected"):
			$status = '<span class="g-chip danger ' . $c_class . '">' . lang('nav_nopass') . '</span>';
			break;
		case ($status_approve == "ปกติ" || $status_approve == "Normal"):
			$status = '<span class="g-chip info ' . $c_class . '">' . lang('sup_normal') . '</span>';
			break;
		case ($status_approve == "สาย" || $status_approve == "Late"):
			$status = '<span class="g-chip danger ' . $c_class . '">' . lang('nav_late') . '</span>';
			break;
		case ($status_approve == "ขาดงาน"):
			$status = '<span class="g-chip danger ' . $c_class . '">' . lang('nav_absent') . '</span>';
			break;
		case ($status_approve == "ออกก่อน"):
			$status = '<span class="g-chip ' . $c_class . '">' . lang('nav_leaveEarly') . '</span>';
			break;
		case ($status_approve == "ลา"):
			$status = '<span class="g-chip warning ' . $c_class . '">' . lang('nav_leavec') . '</span>';
			break;
		case ($status_approve == "สาย, ออกก่อน"):
			$status = '<span class="g-chip danger ' . $c_class . '">' . lang('nav_late') . ", " . lang('nav_leaveEarly') . '</span>';
			break;
		case ($status_approve == "พักงาน"):
			$status = '<span class="g-chip danger ' . $c_class . '">' . "พักงาน" . '</span>';
			break;
		default:
			$status = '';
	}
	return $status;
}

//status badge mobile
function switchstatusbadgeshow_mobile($status_approve = null, $c_class = null)
{  // function to switch status
	$status = '';
	switch (true) {
		case ($status_approve == "approve" || $status_approve == "Approved"):
			$status = '<span class="badge rounded-pill bg-success ' . $c_class . '">' . lang('nav_Pass') . '</span>';
			break;
		case ($status_approve == "pending" || $status_approve == "Pending"):
			$status = '<span class="badge rounded-pill bg-warning text-dark ' . $c_class . '">' . lang('nav_wait') . '</span>';
			break;
		case ($status_approve == "reject" || $status_approve == "Rejected"):
			$status = '<span class="badge rounded-pill  bg-danger ' . $c_class . '">' . lang('nav_nopass') . '</span>';
			break;
		case ($status_approve == "ปกติ" || $status_approve == "Normal"):
			$status = '<span class="badge rounded-pill bg-primary ' . $c_class . '">' . lang('sup_normal') . '</span>';
			break;
		case ($status_approve == "สาย" || $status_approve == "Late"):
			$status = '<span class="badge rounded-pill bg-danger ' . $c_class . '">' . lang('nav_late') . '</span>';
			break;
		case ($status_approve == "ขาดงาน"):
			$status = '<span class="badge rounded-pill bg-danger ' . $c_class . '">' . lang('nav_absent') . '</span>';
			break;
		case ($status_approve == "ออกก่อน"):
			$status = '<span class="badge rounded-pill bg-secondary ' . $c_class . '">' . lang('nav_leaveEarly') . '</span>';
			break;
		case ($status_approve == "ลา"):
			$status = '<span class="badge rounded-pill bg-warning text-dark ' . $c_class . '">' . lang('nav_leavec') . '</span>';
			break;
		case ($status_approve == "สาย, ออกก่อน"):
			$status = '<span class="badge rounded-pill bg-danger text-dark ' . $c_class . '">' . lang('nav_late') . ", " . lang('nav_leaveEarly') . '</span>';
			break;
		case ($status_approve == "พักงาน"):
			$status = '<span class="badge rounded-pill bg-danger text-dark' . $c_class . '">' . "พักงาน" . '</span>';
			break;
		default:
			$status = '';
	}
	return $status;
}

//เพิ่มโดยออฟ ใช้สำหรับส่ง api ไปทำการตัดพื้นหลังใน remove.bg 11/05/65
function send_removebg($file_path)
{
	$apiURL = "https://api.remove.bg/v1.0/removebg";
	//api key สร้างโดยพี่โชค
	$arr_key_api_removebg = [
		'S983XKriGXW6q3SkMDdnsYCQ',
		'bP1kZUvZFmJFETqcwmk6rybH'
	];

	foreach ($arr_key_api_removebg as $value) {
		//CURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiURL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"x-api-key: {$value}",
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, [
			'image_url' => $file_path,
		]);
		$server_output = curl_exec($ch);
		$message_output = json_decode($server_output);
		curl_close($ch);

		//ตรวจสอบว่ามีเออเรอหรือไม่
		if (isset($message_output->errors)) {
			if ($message_output->errors[0]->code != "insufficient_credits") {
				return array("message_output" => $message_output->errors[0]->title);
			}
		} else {
			return array("message_output" => "success", "img" => $server_output);
		}
	}
}

//เพิ่มโดยออฟ ใช้สำหรับเรียกปุ่มสำหรับ mobile 28/05/65
function get_button($action = "", $class = "", $id = "", $name = "", $type = "button")
{
	$html_button = "";
	$id = ($id) ? "id='$id'" : "";
	$name = ($name) ? "name='$name'" : "";

	if ($action == "back") {
		$html_button = "<button type='$type' class='btn btn-black $class' $name $id data-bs-dismiss='modal'>
							<i class='fas fa-chevron-left pe-2'></i> " . lang('nav_back') . "
						</button>";
	} else if ($action == "cancel") {
		$html_button = "<button type='$type' class='btn btn-black $class' $name $id data-bs-dismiss='modal'>&nbsp;"
			. lang('nav_cancel') .
			"&nbsp;</button>";
	} else if ($action == "send") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-gold $class' $name $id>&nbsp;"
			. lang('nav_send') .
			"&nbsp;</button>";
	} else if ($action == "save") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-gold $class' $name $id>&nbsp;"
			. lang('nav_save') .
			"&nbsp;</button>";
	} else if ($action == "confirm") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-gold $class' $name $id>&nbsp;"
			. lang('nav_confirm') .
			"&nbsp;</button>";
	} else if ($action == "approve") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-approve-eva $class' $name $id>&nbsp;"
			. lang('nav_Pass') .
			"&nbsp;</button>";
	} else if ($action == "reject") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-reject-eva $class' $name $id>&nbsp;"
			. lang('nav_nopass') .
			"&nbsp;</button>";
	} else if ($action == "reconsider") { //ใช้สำหรับ evaluate ด้วย
		$html_button = "<button type='$type' class='btn btn-reconsider-eva $class' $name $id>&nbsp;"
			. lang('nav_Resonsider') .
			"&nbsp;</button>";
	} else if ($action == "file") {
		$html_button = "<div class='btn btn-gold border-0 btn-file px-4'>
			<i class='fas fa-paperclip'></i> " . lang('nav_attachfile') . "
			<input class='$class' type='file' name='" . $name . "[]' id='$id' multiple='multiple'>
		</div>";
	}
	return $html_button;
}

/** ฟังก์ชันสำหรับแปลงนาทีเป็น วัน ชั่วโมง นาที (สำหรับคิดเวลาการลา)
 */
function convertMinuteToTimeBaseOnShiftHour($min, $base)
{
	$sec = $min * 60;
	$day = 0;
	$hour = 0;
	$minute = 0;

	if ($min > 0) {
		$day = floor($sec / (3600 * $base));
		$hour = floor(($sec % (3600 * $base)) / 3600);
		$minute = floor($sec % 3600 / 60);
		$timeResult = array("day" => ($day != 0 ? $day . " วัน " : ""), "hour" => ($hour != 0 ? $hour . " ชั่วโมง " : ""), "minute" => ($minute != 0 ? $minute . " นาที " : ""));
	}


	return $timeResult;
}

// ฟังก์ชั่นคำนวณในโปรแกรม payroll
function caltax($salary_sum = null, $result_tax, $pd_id = null)
{
	$CI = &get_instance();
	$mydb = $CI->db;
	$result_deduct = $mydb->query("SELECT sum_money_true FROM geerang_hrm.deduction WHERE pd_id = $pd_id")->row();
	$deduct_tax = 0;
	if (!empty($result_deduct)) {
		$deduct_tax = $result_deduct->sum_money_true;
	}

	if ($salary_sum) {
		$tax_cal = ($salary_sum * 12);
		$discut_person =  ($tax_cal * 0.50);  //หัก 50 % ไม่เกิน 100000 บาท 
		if ($discut_person > 100000) {
			$discut_person = 100000;
		}
		//หักลดหย่อน

		if ($deduct_tax > 0) {
			$discut_self = $deduct_tax;
		} else {
			$discut_self = 60000;
		}
		$sso = 9000;

		$sum_cal = $tax_cal - ($discut_person + $discut_self + $sso);



		$cal_tax = 0;
		foreach ($result_tax as $key => $val) {
			//    print_r($result_tax);
			if ($sum_cal >  5000000) {
				$cal_percent = 0.35;
				$cal_tax  = ($sum_cal * $cal_percent);
			} else if ($sum_cal >= $val['salary_from']  && $sum_cal < $val['salary_to']) {
				if ($val['result_text'] != 'ได้รับการยกเว้น') {
					// echo $key.$val['result_text'].$sum_cal.'<br>';
					$ar_sum = [];
					for ($i = 0; $i < $key; $i++) {
						$ar_sum[] = $result_tax[$i]['pay_step'];
					}
					// print_r($ar_sum); 
					$cal_total_tax = ($sum_cal - $val['salary_from']) . '<br>';

					$cal_percent = (str_replace('%', '', $val['result_text']) / 100);
					$cal_tax  = ($cal_total_tax * $cal_percent) + array_sum($ar_sum);
				} else {
					$cal_tax = 0;
				}
			}
		}
		return ($cal_tax > 0 ? $cal_tax / 12 : 0);
	}
}

function callate($salary = null, $day = null, $c_type = null, $type = null, $num = null)
{
	// var_export(func_get_args());
	if ($c_type == 'hour') {
		$total_salary = (($salary / 60) * $num);
	} else if ($c_type == 'day') {
		$total_salary = ((($salary / $day) / 60)) * $num;
	} else if ($c_type == 'month') {
		$total_salary = (((($salary / $day) / 8) / 60)) * $num;
	}

	if ($type == 'late') {
		if ($type == 'late' && ($c_type == 'month' ||  $c_type == 'day')) {
			$data['late'] = $total_salary;
		} else {
			$data['late'] = 0;
		}
	}

	if ($type == 'early') {
		if ($type == 'early' && ($c_type == 'month' ||  $c_type == 'day')) {
			$data['early'] = $total_salary;
		} else {
			$data['early'] = 0;
		}
	}

	return $data;
}

function calabsent($salary = null, $day = null, $c_type = null, $type = null, $num = null)
{
	// var_export(func_get_args());
	if ($c_type == 'hour') {
		$total_salary = (($salary / 60) * $num);
	} else if ($c_type == 'day') {
		$total_salary = ((($salary / $day) / 60)) * $num;
	} else if ($c_type == 'month') {
		$total_salary = (((($salary / $day) / 8) / 60)) * $num;
	}

	if ($type == 'absent' && ($c_type == 'month' )) {
		$data['absent'] = $total_salary;
	} else {
		$data['absent'] = 0;
	}
	return $data;
}

function calleave($salary = null, $day = null, $c_type = null, $type = null, $num = null)
{ 
	// var_export(func_get_args());
	if ($c_type == 'hour') {
		$total_salary = (($salary / 60) * $num);
	} else if ($c_type == 'day') {
		$total_salary = ((($salary / $day) / 60)) * $num;
	} else if ($c_type == 'month') {
		$total_salary = (((($salary / $day) / 8) / 60)) * $num;
	}

	if ($type == 'leave' && ($c_type == 'month')) {
		$data['leave'] = $total_salary;
	} else {
		$data['leave'] = 0;
	}
	return $data;
}

function calleave_outside($salary = null, $day = null, $c_type = null, $type = null, $num = null)
{ 
	// var_export(func_get_args());
	if ($c_type == 'hour') {
		$total_salary = (($salary / 60) * $num);
	} else if ($c_type == 'day') {
		$total_salary = ((($salary / $day) / 60)) * $num;
	} else if ($c_type == 'month') {
		$total_salary = (((($salary / $day) / 8) / 60)) * $num;
	}

	if ($type == 'leave_outside') {
		$data['leave'] = $total_salary;
	} else {
		$data['leave'] = 0;
	}
	return $data;
}



function check_ottime($salary = null, $day = null, $c_type = null, $time = null, $exc = null)
{
	$total_salary = 0;
	if ($c_type == 'hour') {
		$total_salary = (($salary / 60));
	} else if ($c_type == 'day') {
		$total_salary = ((($salary / $day) / 60));
	} else if ($c_type == 'month') {
		$total_salary = (((($salary / $day) / 8) / 60));
	}
	$data = ($total_salary * $time) * $exc;

	return $data;
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

function check_salary($group_type = null, $salary = null, $day, $hour, $start_day = null, $endday = null)
{
	$total_salary = 0;
	if ($group_type == 'hour') {
		$pmin = ($salary / 60);
		$arr = explode(':', $hour);
		$total_salary = ($salary * $arr[0]) + ($pmin * $arr[1]);
	} else if ($group_type == 'day') {
		$total_salary = ($day * $salary);
	} else if ($group_type == 'month') {
		$total_salary = ($salary / 30) * monthDateDiff($start_day, $endday)['daydeduct'];
	}

	$ar = [
		// 'pday' => ($pday?$pday:0),
		// 'pmin' => ($pmin?$pmin:0),
		// 'phour' => $phour,
		'salary' => $salary,
		'total_salary' => $total_salary,
	];


	return $ar;
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
// check sso ออกหลายรอบในเดือนเดียวไม่ให้ตัดซ้ำ 
function checksso($pd_id = null, $month = null)
{
	$CI = &get_instance();
	$mydb = $CI->db;
	$com_id = $CI->session->userdata('company_id');
	$result = $mydb->query(" SELECT
									sum(pt.pay_support) AS sumsso,
									pt.payroll_id,
									pd.pd_id,
									(SUM(pt.base_salary) - SUM(pt.deduct_early) - SUM(pt.deduct_absent) - SUM(pt.deduct_leave) - SUM(pt.deduct_late) - SUM(pt.outcome_sumsso) + SUM(pt.income_sumsso)) AS salarySUM
								FROM
									geerang_hrm.payroll_tax pt
								LEFT JOIN geerang_gts.personaldocument pd ON pd.id_card = pt.idcard
								WHERE
									MONTH (pt.pay_date) = $month 
								AND pt.company_id = $com_id
								AND pd.pd_id = '$pd_id'  
								GROUP BY pt.payroll_id
								ORDER BY pt.pay_date ASC 
        					")->result_array();
	$sum_sso = 0;
	$result_sso = [];
	foreach ($result as $row) {
		$result_sso[$row['pd_id']] = ['sumsso' => $row['sumsso'], 'salary' => $row['salarySUM']];
	}

	return $result_sso;
}
//check return 	
function check_return_sso($ar_check = null, $max_value = null, $value_check = null)
{
	$check_sum = [];
	$return_sum = 0;
	for ($i = 1; $i <= count($ar_check); $i++) {
		$check_sum[] = $ar_check[$i];
	}
	$check_sum = array_sum($check_sum);
	if ($check_sum >= $max_value) {
		$return_sum = 0;
	} else if ($check_sum < $max_value) {
		$return_sum = $max_value - $check_sum;
	}
	return $return_sum;
}

function checksso_condition()
{
}
// สิ้นสุดฟังชั่น payroll

function announce_priority($priority = null)
{
	if ($priority == 'High') {
		return 'danger';
	} else if ($priority == 'Medium') {
		return 'warning';
	} else if ($priority == 'Normal') {
		return 'success';
	}
}

function check_pms_free5user($app_id = 4)
{
	$CI = &get_instance();
	$result_order = $CI->db->order_by('package_end DESC')->get_where('geerang_gts.orders', array('application_id' => $app_id, 'company_id' => $CI->session->userdata('company_id')), 1)->row();

	if (!empty($result_order->order_id)) {
		$result = $CI->db->query("SELECT ogl.*,pg.package_type 
						FROM geerang_gts.order_get_list ogl 
						LEFT JOIN geerang_gts.package pg ON pg.package_id = ogl.package_id
						WHERE
						pg.package_type = 'FREE2'
						AND ogl.order_id = {$result_order->order_id}")->row();
		if (!empty($result)) {
			return true;
		}
	}
	return false;
}

function switchstatusbadgeshowEss($status_approve = null, $c_class = null, $id_track = null, $status_track = null)
{  // function to switch status

	$status = '';
	switch (true) {
		case ($status_approve == 'cancelled' || $status_approve == 'Cancelled'):
			$status = '<span class="g-chip font--s g-chip-small danger ' . $c_class . '">' . lang('nav_cancel') . '</span>';
			break;
		case (($status_approve == "approve" || $status_approve == "Approved") || (!empty($id_track) && $status_track == 'approve')):
			$status = '<span class="g-chip font--s g-chip-small success ' . $c_class . '">' . lang('nav_Pass') . '</span>';
			break;
		case ((($status_approve == "pending" || $status_approve == "Pending") && empty($id_track)) || (!empty($id_track) && $status_track == 'pending')):
			$status = '<span class="g-chip font--s g-chip-small warning ' . $c_class . '">' . lang('nav_wait') . '</span>';
			break;
		case ($status_approve == "reject" || $status_approve == "Rejected"):
			$status = '<span class="g-chip font--s g-chip-small danger ' . $c_class . '">' . lang('nav_nopass') . '</span>';
			break;
		default:
			$status = '';
	}
	return $status;
}


function switchstatusbadgeshowEss_mobile($status_approve = null, $c_class = null, $id_track = null, $status_track = null)
{  // function to switch status

	$status = '';
	switch (true) {
		case ($status_approve == "reject" || $status_approve == "Rejected" || $status_approve == "Cancelled" || $status_approve == 'cancelled'):
			$status = 'bg-danger';
			break;
		case (($status_approve == "approve" || $status_approve == "Approved") || (!empty($id_track) && $status_track == 'approve')):
			$status = 'bg-success';
			break;
		case ((($status_approve == "pending" || $status_approve == "Pending") && empty($id_track)) || (!empty($id_track) && $status_track == 'pending') && $status_approve != "Cancelled"):
			$status = 'bg-yellow';
			break;
		default:
			$status = '';
	}
	return $status;
}

function createMonth()
{
	// wait for change eng text to multi language
	$month = ['', lang('nav_jan'), lang('nav_feb'), lang('nav_mar'), lang('nav_apr'), lang('nav_may'), lang('nav_jun'), lang('nav_jul'), lang('nav_aug'), lang('nav_sep'), lang('nav_oct'), lang('nav_nov'), lang('nav_dec')];
	return $month;
}

function convertDateSave($date)
{
	return date('Y-m-d', strtotime($date));
};


//create by hit choke 12/01/66 
function calNumOfWork($pd_id = NULL, $com_id = NULL)
{
	$CI = &get_instance();
	$mydb = $CI->db;
	$start_work = $mydb->query("SELECT ABS(DATEDIFF(start_work,curdate())) AS count_workday, start_work
                                FROM geerang_hrm.personalsecret
                                WHERE pd_id = ?
                                AND company_id = ?", [$pd_id, $com_id])->row('start_work');

	return date_diff_string($start_work, 'now', true);
}

function date_diff_string($from, $to, $full = false)
{
	$from = new DateTime($from);
	$to = new DateTime($to);
	$diff = $to->diff($from);

	$string = array(
		'y' => lang('nav_year'),
		'w' => lang('nav_week'),
		'm' => lang('nav_month'),
		'd' => lang('nav_datea'),
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) : 'เริ่มวันแรก';
}

function loadWorkdayLastyear($pd_id, $com_id)
{
	try {
		$CI = &get_instance();
		$mydb = $CI->db;

		$end_lastyear = date("Y-m-d", strtotime("last year December 31st"));

		$result = $mydb->query("SELECT ABS(DATEDIFF(start_work, ?)) AS count_workday
                                            FROM geerang_hrm.personalsecret t1
                                            LEFT JOIN geerang_hrm.employee_type t2
                                            ON t1.employee_type_id = t2.id 
                                            WHERE t1.company_id = ? 
                                            AND t1.pd_id = ?", [$end_lastyear, $com_id, $pd_id]);

		if ($result->num_rows() == 0) throw new Exception("", 1);

		return $result->row('count_workday');
	} catch (\Throwable $th) {
		return 0;
	}
}

function HTMLToRGB($htmlCode)
  {
    if($htmlCode[0] == '#')
      $htmlCode = substr($htmlCode, 1);

    if (strlen($htmlCode) == 3)
    {
      $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
    }

    $r = hexdec($htmlCode[0] . $htmlCode[1]);
    $g = hexdec($htmlCode[2] . $htmlCode[3]);
    $b = hexdec($htmlCode[4] . $htmlCode[5]);

    return $b + ($g << 0x8) + ($r << 0x10);
  }

function RGBToHSL($RGB) {
    $r = 0xFF & ($RGB >> 0x10);
    $g = 0xFF & ($RGB >> 0x8);
    $b = 0xFF & $RGB;

    $r = ((float)$r) / 255.0;
    $g = ((float)$g) / 255.0;
    $b = ((float)$b) / 255.0;

    $maxC = max($r, $g, $b);
    $minC = min($r, $g, $b);

    $l = ($maxC + $minC) / 2.0;

    if($maxC == $minC)
    {
      $s = 0;
      $h = 0;
    }
    else
    {
      if($l < .5)
      {
        $s = ($maxC - $minC) / ($maxC + $minC);
      }
      else
      {
        $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
      }
      if($r == $maxC)
        $h = ($g - $b) / ($maxC - $minC);
      if($g == $maxC)
        $h = 2.0 + ($b - $r) / ($maxC - $minC);
      if($b == $maxC)
        $h = 4.0 + ($r - $g) / ($maxC - $minC);

      $h = $h / 6.0; 
    }

    $h = (int)round(255.0 * $h);
    $s = (int)round(255.0 * $s);
    $l = (int)round(255.0 * $l);

    return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
  }

function fileExists($picture_path, $type = 'profile') 
{
	$image_no_found = '';
	switch ($type) {
		case 'profile':
			$image_no_found = 'assets/images/icon/blank_person.jpg';
			break;
		
		default:
			# code...
			break;
	}
	return $picture_path && file_exists($picture_path) ? base_url().substr($picture_path, 2) : base_url().$image_no_found;
}

