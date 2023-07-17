<?php

defined('BASEPATH') or exit('No direct script access allowed');



$config['title'] = array(

    ""         => "", "other"    => "", "4"    => "", '0' => '',

    "1"     => "Mr. ",     "Mr."     => "Mr. ",

    "2"        => "Mrs. ", "Mrs."     => "Mrs. ",

    "3"     => "Miss ", "Miss"     => "Miss "
);

$config['titleth'] = array(

    ""         => "", "other"    => "", "4"    => "", '0' => '',

    "1"     => "นาย ",     "Mr."     => "นาย ",

    "2"        => "นาง ",     "Mrs."     => "นาง ",

    "3"     => "นางสาว ", "Miss"     => "นางสาว "
);

$config['titleen'] = array(

    ""         => "", "other"    => "", "4"    => "", '0' => '',

    "1"     => "Mr. ",     "Mr."     => "นาย ",

    "2"        => "Mrs. ",     "Mrs."     => "นาง ",

    "3"     => "Miss ", "Miss"     => "นางสาว "
);

$config['title_option'] = array(

    array('value' => '1', 'label' => 'Mr.',),

    array('value' => '2', 'label' => 'Mrs.',),

    array('value' => '3', 'label' => 'Miss',),

    array('value' => '4', 'label' => 'Other',),

);

$config['title_option_th'] = array(

    array('value' => '1', 'label' => 'นาย',),

    array('value' => '2', 'label' => 'นาง',),

    array('value' => '3', 'label' => 'นางสาว',),

    array('value' => '4', 'label' => 'อื่นๆ',),

);



$config['marital_status'] = array("" => "", '1' => "Single", '2' => "Married", '3' => "Divorced", '4' => "Widowed", '5' => "Separate");

$config['marital_status_th'] = array("" => "", '1' => "โสด", '2' => "แต่งงาน", '3' => "หย่าร้าง", '4' => "หม้าย", '5' => "แยกทาง");

$config['marital_option'] = array(

    array('value' => '1', 'label' => 'Single'),

    array('value' => '2', 'label' => 'Married'),

    array('value' => '3', 'label' => 'Divorced'),

    array('value' => '4', 'label' => 'Widowed'),

    array('value' => '5', 'label' => 'Separate'),

);

$config['marital_option_th'] = array(

    array('value' => '1', 'label' => 'โสด'),

    array('value' => '2', 'label' => 'แต่งงาน'),

    array('value' => '3', 'label' => 'หย่าร้าง'),

    array('value' => '4', 'label' => 'หม้าย'),

    array('value' => '5', 'label' => 'แยกทาง'),

);



$config['military_status'] = array('' => '', '1' => 'Pending', '2' => 'Complete', '3' => 'Exempt');

$config['military_status_th'] = array('' => '', '1' => 'ยังไม่ได้เกณฑ์ทหาร', '2' => 'ผ่านการเกณฑ์แล้ว', '3' => 'ได้รับการยกเว้น');

$config['military_option'] = array(

    array('value' => '1', 'label' => 'Pending'),

    array('value' => '2', 'label' => 'Complete'),

    array('value' => '3', 'label' => 'Exempt')

);

$config['military_option_th'] = array(

    array('value' => '1', 'label' => 'ยังไม่ได้เกณฑ์ทหาร'),

    array('value' => '2', 'label' => 'ผ่านการเกณฑ์แล้ว'),

    array('value' => '3', 'label' => 'ได้รับการยกเว้น')

);





$config['gender'] = array(
    "" => "", 0 => "", 1 => "Male", 2 => "Female",

    3 => "Male or Female", 12 => "Male or Female", 13 => "Male or Female", 123 => "Male or Female",

    "Other" => "Male or Female"

);



$config['genderth'] = array(
    "" => "", 0 => "", 1 => "ขาย", 2 => "หญิง",

    3 => "ชาย หรือ หญิง", 12 => "ชาย หรือ หญิง", 13 => "ชาย หรือ หญิง", 123 => "ชาย หรือ หญิง",

    "Other" => "Male or Female"

);

$config['gender_option'] = array(

    array('value' => '1', 'label' => 'Male'),

    array('value' => '2', 'label' => 'Female'),

    array('value' => '3', 'label' => 'Other'),

);

$config['gender_option_th'] = array(

    array('value' => '1', 'label' => 'ชาย'),

    array('value' => '2', 'label' => 'หญิง'),

    array('value' => '3', 'label' => 'อื่นๆ'),

);



$config['job_type_option'] = array(

    // array('value'=>'0','label'=>'Full time'),

    // array('value'=>'1','label'=>'Part time'),

    // array('value'=>'4','label'=>'Contract'),

    // array('value'=>'2','label'=>'Freelance'),

    // array('value'=>'3','label'=>'Internship'),

    array('value' => '0', 'label' => 'Permanent'),

    array('value' => '4', 'label' => 'Contract / Temporary'),

    array('value' => '1', 'label' => 'Part Time'),

    array('value' => '2', 'label' => 'Freelance'),

    array('value' => '3', 'label' => 'Internship'),

);

$config['jobtype'] = array(

    // '' =>'', 0 => 'Full time', 1 => 'Part Time', 

    // 4 => 'Contract', 2 => 'Freelance', 3 => 'Internship'

    '' => '', 0 => 'Permanent', 1 => 'Part Time',

    4 => 'Contract / Temporary', 2 => 'Freelance', 3 => 'Internship'

);



$config['employmentLevel_option'] = array(

    array('value' => 'Staff', 'label' => 'Staff'),

    array('value' => 'Supervisor', 'label' => 'Supervisor'),

    array('value' => 'Manager', 'label' => 'Manager / Senior Manager'),

    array('value' => 'Executive', 'label' => 'Executive'),

);

$config['employmentLevel'] = array(
    'Staff' => 'Staff',

    'Supervisor' => 'Supervisor',    'Manager' => 'Manager / Senior Manager',

    'Executive' => 'Executive',
);



$config['saturday_seeker_option'] = array(

    array('value' => '0', 'label' => 'No, I can’t (or 5 days/week)'),

    array('value' => '4', 'label' => 'Yes, I can work every Saturday. (or 6 days/week)'),

    array('value' => '1', 'label' => 'Yes, I can work only some Saturday. (or work half day on Saturday)'),

    // array('value'=>'5','label'=>'Sometimes : only half day'),

);



$config['saturday'] = array(
    array('value' => '0', 'label' => 'not work on saturday'),

    array('value' => '1', 'label' => 'work on saturday 1 day/mounth, all day'),

    array('value' => '2', 'label' => 'work on saturday 2 day/mounth, all day'),

    array('value' => '3', 'label' => 'work on saturday 3 day/mounth, all day'),

    array('value' => '4', 'label' => 'work on every saturday, all day'),

    array('value' => '5', 'label' => 'work on saturday 1 day/mounth, haft day'),

    array('value' => '6', 'label' => 'work on saturday 2 day/mounth, haft day'),

    array('value' => '7', 'label' => 'work on saturday 3 day/mounth, haft day'),

    array('value' => '8', 'label' => 'work on every saturday day, haft day'),
);



$config['saturdayDisplay'] = array(
    '0' => 'No, I can’t (or 5 days/week)',

    '1' => 'Yes, I can work only some Saturday. (or work half day on Saturday)',

    '2' => 'Yes, I can work every Saturday. (or 6 days/week)',

    '3' => 'Yes, I can work only some Saturday. (or work half day on Saturday)',
    '', null => ''
);



$config['work_notice_option'] = array(

    array('value' => '0', 'label' => 'Immediately'),

    array('value' => '7', 'label' => '7 days notice'),

    array('value' => '15', 'label' => '15 days notice'),

    array('value' => '30', 'label' => '30 days notice'),

    array('value' => '45', 'label' => '45 days notice'),

    array('value' => '60', 'label' => '60 days notice'),

);



$config['months'] = array(

    array("value" => 1, "label" => "Jan"),

    array("value" => 2, "label" => "Feb"),

    array("value" => 3, "label" => "Mar"),

    array("value" => 4, "label" => "Apr"),

    array("value" => 5, "label" => "May"),

    array("value" => 6, "label" => "Jun"),

    array("value" => 7, "label" => "Jul"),

    array("value" => 8, "label" => "Aug"),

    array("value" => 9, "label" => "Sep"),

    array("value" => 10, "label" => "Oct"),

    array("value" => 11, "label" => "Nov"),

    array("value" => 12, "label" => "Dec"),

);



$config['monthsTH'] = array(

    array("value" => 1, "label" => "ม.ค."),

    array("value" => 2, "label" => "ก.พ."),

    array("value" => 3, "label" => "มี.ค."),

    array("value" => 4, "label" => "เม.ย."),

    array("value" => 5, "label" => "พ.ค."),

    array("value" => 6, "label" => "มิ.ย."),

    array("value" => 7, "label" => "ก.ค."),

    array("value" => 8, "label" => "ส.ค."),

    array("value" => 9, "label" => "ก.ย."),

    array("value" => 10, "label" => "ต.ค."),

    array("value" => 11, "label" => "พ.ย."),

    array("value" => 12, "label" => "ธ.ค."),

);





$config['monthsArray'] = array(

    '' => '', 'Present' => '',

    "1" => "Jan", 'Jan' => 'Jan',

    "2" => "Feb", 'Feb' => 'Feb',

    "3" => "Mar", 'Mar' => 'Mar',

    "4" => "Apr", 'Apr' => 'Apr',

    "5" => "May", 'May' => 'May',

    "6" => "Jun", 'Jun' => 'Jun',

    "7" => "Jul", 'Jul' => 'Jul',

    "8" => "Aug", 'Aug' => 'Aug',

    "9" => "Sep", 'Sep' => 'Sep',

    "10" => "Oct", 'Oct' => 'Oct',

    "11" => "Nov", 'Nov' => 'Nov',

    "12" => "Dec", 'Dec' => 'Dec',

);

$config['monthsArrayTH'] = array(

    '' => '', 'ปัจจุบัน' => '',

    "1" => "ม.ค.", 'Jan' => 'ม.ค.',

    "2" => "ก.พ.", 'Feb' => 'ก.พ.',

    "3" => "มี.ค.", 'Mar' => 'มี.ค.',

    "4" => "เม.ย.", 'Apr' => 'เม.ย.',

    "5" => "พ.ค.", 'May' => 'พ.ค.',

    "6" => "มิ.ย.", 'Jun' => 'มิ.ย.',

    "7" => "ก.ค.", 'Jul' => 'ก.ค.',

    "8" => "ส.ค.", 'Aug' => 'ส.ค.',

    "9" => "ก.ย.", 'Sep' => 'ก.ย.',

    "10" => "ต.ค.", 'Oct' => 'ต.ค.',

    "11" => "พ.ย.", 'Nov' => 'พ.ย.',

    "12" => "ธ.ค.", 'Dec' => 'ธ.ค.',

);



$Y = intval(date("Y"));

$config['years'] = array();

$years = range($Y, 1950, -1);

foreach ($years as $value) {

    $config['years'][] = ['value' => $value, 'label' => $value];
}



$config['levelETest'] = array();

$config['levelETest']['WEB'] = array(

    '10' => 'Excellent',    '9' => 'Excellent',

    '8'    => 'Good',            '7' => 'Good',

    '6' => 'Average',        '5' => 'Average',

    '4' => 'Fair',            '3' => 'Fair',

    '2' => 'Poor',            '1' => 'Poor',

    '0' => 'None',

    ''     => '',                 'None' => 'None',

);

$config['levelETest']['JPR'] = array(

    '10' => 'Excellent',    '9' => 'Excellent',

    '8'    => 'Good',            '7' => 'Good',

    '6' => 'Average',        '5' => 'Average',

    '4' => 'Fair',            '3' => 'Fair',

    '2' => 'Poor',            '1' => 'Poor',

    '0' => 'None',

    ''     => '',                 'None' => 'None',

);

$config['levelETest']['ALINK'] = array(

    '10' => 'Excellent',

    '9'    => 'Good+',        '8'    => 'Good',        '7' => 'Good-',

    '6' => 'Average+',    '5' => 'Average',    '4' => 'Average-',

    '3' => 'Little+',    '2' => 'Little',    '1' => 'Little',

    '0' => 'None',

    ''     => '', 'None' => 'None',

);





$config['langLevel'] = array();

$config['langLevel']['WEB'] = array(

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label'    => 'Good'),

    array('level' => '5', 'label' => 'Average'),

    array('level' => '3', 'label' => 'Fair'),

    array('level' => '1', 'label' => 'Poor'),

    array('level' => '0', 'label' => 'None'),

);

$config['langLevel']['JPR'] = array(

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label'    => 'Good'),

    array('level' => '5', 'label' => 'Average'),

    array('level' => '3', 'label' => 'Fair'),

    array('level' => '1', 'label' => 'Poor'),

    array('level' => '0', 'label' => 'None'),

);

$config['langLevel']['ALINK'] = array(

    array('level' => '10', 'label' => 'Excellent'),

    array('level' => '9', 'label'    => 'Good+'),

    array('level' => '8', 'label'    => 'Good'),

    array('level' => '7', 'label' => 'Good-'),

    array('level' => '6', 'label' => 'Average+'),

    array('level' => '5', 'label' => 'Average'),

    array('level' => '4', 'label' => 'Average-'),

    array('level' => '3', 'label' => 'Little+'),

    array('level' => '1', 'label' => 'Little'),

    array('level' => '0', 'label' => 'None'),

);



$config['langDisplay'] = array(

    'WEB' => array(

        array('level' => '10', 'label' => 'Excellent'),

        array('level' => '9', 'label' => 'Excellent'),

        array('level' => '8', 'label'    => 'Good'),

        array('level' => '7', 'label'    => 'Good'),

        array('level' => '6', 'label' => 'Average'),

        array('level' => '5', 'label' => 'Average'),

        array('level' => '4', 'label' => 'Fair'),

        array('level' => '3', 'label' => 'Fair'),

        array('level' => '2', 'label' => 'Poor'),

        array('level' => '1', 'label' => 'Poor'),

        array('level' => '0', 'label' => 'None'),

    ),

    'JPR' => array(

        array('level' => '10', 'label' => 'Excellent'),

        array('level' => '9', 'label' => 'Excellent'),

        array('level' => '8', 'label'    => 'Good'),

        array('level' => '7', 'label'    => 'Good'),

        array('level' => '6', 'label' => 'Average'),

        array('level' => '5', 'label' => 'Average'),

        array('level' => '4', 'label' => 'Fair'),

        array('level' => '3', 'label' => 'Fair'),

        array('level' => '2', 'label' => 'Poor'),

        array('level' => '1', 'label' => 'Poor'),

        array('level' => '0', 'label' => 'None'),

    ),

    'ALINK' => array(

        array('level' => '10', 'label' => 'Excellent'),

        array('level' => '9', 'label'    => 'Good+'),

        array('level' => '8', 'label'    => 'Good'),

        array('level' => '7', 'label' => 'Good-'),

        array('level' => '6', 'label' => 'Average+'),

        array('level' => '5', 'label' => 'Average'),

        array('level' => '4', 'label' => 'Average-'),

        array('level' => '3', 'label' => 'Little+'),

        array('level' => '2', 'label' => 'Little'),

        array('level' => '1', 'label' => 'Little'),

        array('level' => '0', 'label' => 'None'),

    )

);



$config['langJobLevel'] = array();

$config['langJobLevel']['WEB'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '1', 'label' => 'Poor & higher'),

);

$config['langJobLevel']['JPR'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '1', 'label' => 'Poor & higher'),

);

$config['langJobLevel']['ALINK'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '1', 'label' => 'Poor & higher'),

);



$config['langJobDisplay'] = array();

$config['langJobDisplay']['WEB'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '1', 'label' => 'Poor & higher'),

    array('level' => '2', 'label' => 'Fair & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '4', 'label' => 'Average & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '6', 'label' => 'Good & higher'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '8', 'label' => 'Excellent'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '', 'label' => 'All'),

);

$config['langJobDisplay']['JPR'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '1', 'label' => 'Poor & higher'),

    array('level' => '2', 'label' => 'Fair & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '4', 'label' => 'Average & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '6', 'label' => 'Good & higher'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '8', 'label' => 'Excellent'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '', 'label' => 'All'),

);

$config['langJobDisplay']['ALINK'] = array(

    array('level' => null, 'label' => 'All'),

    array('level' => '', 'label' => 'All'),

    array('level' => '9', 'label' => 'Excellent'),

    array('level' => '7', 'label' => 'Good & higher'),

    array('level' => '5', 'label' => 'Average & higher'),

    array('level' => '3', 'label' => 'Fair & higher'),

    array('level' => '1', 'label' => 'Poor & higher'),

);



$config['langCert'] = array(

    array('cert' => 'TOEFL', 'label' => 'TOEFL'),

    array('cert' => 'TOEIC', 'label' => 'TOEIC'),

    array('cert' => 'IELTS', 'label' => 'IELTS'),

    array('cert' => 'GRE', 'label' => 'GRE'),

    array('cert' => 'GMAT', 'label' => 'GMAT')

);

$config['JLPT'] = array(

    array('level' => '1', 'label' => '1'),

    array('level' => '2', 'label'    => '2'),

    array('level' => '3', 'label' => '3'),

    array('level' => '4', 'label' => '4'),

    array('level' => 'N1', 'label' => 'N1'),

    array('level' => 'N2', 'label' => 'N2'),

    array('level' => 'N3', 'label' => 'N3'),

    array('level' => 'N4', 'label' => 'N4'),

    array('level' => 'N5', 'label' => 'N5'),

);

$config['levelcheck'] = array(

    ""     => "",

    "7" => "Doctor's Degree ",

    "6" => "Master's Degree ",

    "5" => "Bachelor's Degree ",

    "4" => "Diploma",

    "3" => "Vocation",

    "2" => "High School",

    "1" => "lower than High School"

);



$config['levelcheck_th'] = array(

    ""     => "",

    "8" => "ปริญญาเอก ",

    "7" => "ปริญญาโท ",

    "6" => "ปริญญาตรี ",

    "5" => "อนุปริญญาตรี ",

    "4" => "ปวส.",

    "3" => "ปวช.",

    "2" => "มัธยม (ม.6)",

    "1" => "ต่ำกว่ามัธยม (ม.6)"

);



$config['levelcheck_option'] = array(

    array('value' => '', 'label' => ''),

    array('value' => '6', 'label' => 'Doctor\'s Degree '),

    array('value' => '5', 'label' => 'Master\'s Degree '),

    array('value' => '4', 'label' => 'Bachelor\'s Degree '),

    array('value' => '3', 'label' => 'Diploma'),

    array('value' => '2', 'label' => 'Vocation'),

    array('value' => '1', 'label' => 'High School'),

    array('value' => '0', 'label' => 'lower than High School'),

);



$config['levelcheck_option_th'] = array(

    array('value' => '', 'label' => ''),

    array('value' => '6', 'label' => 'ปริญญาเอก '),

    array('value' => '5', 'label' => 'ปริญญาโท '),

    array('value' => '4', 'label' => 'ปริญญาตรี '),

    array('value' => '3', 'label' => 'ปวส.'),

    array('value' => '2', 'label' => 'ปวช.'),

    array('value' => '1', 'label' => 'มัธยม (ม.6) '),

    array('value' => '0', 'label' => 'ต่ำกว่ามัธยม (ม.6)'),

);

$config['lang_op'] = array(

    ''    => 'select',

    '9'    => 'Excellent',

    '7'    => 'Good',

    '5' => 'Average',

    '3'    => 'Fair',

    '1'    => 'Poor',

);

$data['japanese_level'] = array(

    ''    => "select", '1'    => '1', '2'    => '2',

    '3'    => '3',     '4'    => '4',

    'n1' => 'N1',    'n2' => 'N2',

    'n3' => 'N3',    'n4' => 'N4',    'n5' => 'N5'
);