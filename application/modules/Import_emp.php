<?php
require_once APPPATH . '/third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Import_emp extends CRUD_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_lang();
        $this->load->helper('cookie');
        $this->load->helper('ci_utilities_helper');

        $this->com_id = $this->session->userdata('company_id');
        $this->pd_id = $this->session->userdata('pd_id');
        $this->load->model('hrm/Import_emp_model', 'import');

        if (empty($this->session->userdata('company_id')) && empty($this->session->userdata('pd_id'))) {
            redirect('gmember');;
        }
    }
    public function index()
    {
        $this->admin();
    }
    public function logout()
    {
        unset($_SESSION['admin']);
        unset($_SESSION['key_import']);
        unset($_SESSION['user_import']);
        redirect('/hrm/import_emp/', 'refresh');
    }
    public function check_admin()
    {

        $post = (object)$this->input->get();
        $by_pass = $this->import->check_bypass($post->username,  $post->password);
        if ($by_pass['status'] == true) {
            $config_data = [
                'admin' => urlencode(encrypt($post->password)),
                'key_import' => urlencode(encrypt($by_pass['key'])),
                'user_import' => urlencode(encrypt($post->username)),
            ];
            $this->session->set_userdata($config_data);

            $data = ['status' => true, 'key' => urlencode(encrypt($by_pass['key'])), 'user' =>  urlencode(encrypt($post->username))];
            echo json_encode($data);
        } else {
            unset($_SESSION['admin']);
            unset($_SESSION['key_import']);
            unset($_SESSION['user_import']);
            echo json_encode(['status' => false]);
        }
    }
    public function admin()
    {

        $this->data['url_admin'] = explode('/', $_SERVER['REQUEST_URI'])[3];

        $this->setJs('assets/lib/jspreadsheet-ce/index.js');
        $this->setJs('assets/lib/jsuites/jsuites.js');
        $this->setCss('assets/lib/jspreadsheet-ce/jspreadsheet.css');
        $this->setCss('assets/lib/jsuites/jsuites.css');
        $this->setJs('/assets/js_modules/hrm/import_excel.js?ft=' . time());
        $this->data['another_js'] =  $this->another_js;
        $this->data['another_css'] =  $this->another_css;
        $this->parser->parse('hrm/employee/import_excel', $this->data);
    }

    public function get_last_empcode()
    {
        $post = (object) $this->input->post();
        try {
            $result = $this->import->get_last_empcode($post);
            $this->setRes($result['status'], $result['data'], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function checkemail()
    {

        $post = (object) $this->input->post();
        try {
            $result = $this->import->checkEmail($post);
            $this->setRes($result['status'], $result['data'], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function checkusername()
    {

        $post = (object) $this->input->post();
        try {
            $result = $this->import->checkusername($post);
            $this->setRes($result['status'], $result['data'], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function checkid_card()
    {

        $post = (object) $this->input->post();
        try {
            $result = $this->import->checkid_card($post);
            $this->setRes($result['status'], $result['data'], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function getPosition_list()
    {
        try {
            $result = $this->import->getPosition_list();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function getUniversity()
    {
        $post = (object) $this->input->get(NULL, FALSE);
        try {
            $result = $this->import->getUniversity($post);
            echo json_encode($result);
            // $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function ImportEmployee()
    {
        $post =  $this->input->post();
        $result = $this->import->ImportEmployee($post);

        $json = json_encode($result);
        echo $json;
    }
    public function createlog()
    {
        try {
            $result = $this->import->createlog();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function updatelog()
    {
        $post = (object) $this->input->POST();
        try {
            $result = $this->import->updatelog($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_logimport()
    {
        try {
            $result = $this->import->get_logimport();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_logimport_new()
    {
        try {
            $result = $this->import->get_logimport_new();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function updatestatus()
    {
        $post = (object) $this->input->post(null, false);
        try {
            $result = $this->import->updateSuccess($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_employee_group()
    {
        try {
            $result = $this->import->get_employee_group();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function save_newimport()
    {
        $post = (object) $this->input->post(null, false);

        try {
            $result = $this->import->save_newimport($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function getStatusList()
    {
        try {
            $result = $this->import->get_emp_waitting();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function save_active_data()
    {
        $post = (object) $this->input->post(null, false);
        try {
            $result = $this->import->save_active_data($post);
            $this->setRes($result['status'], $result['data'], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function temp()
    {
        $this->setJs('/assets/js_modules/users/temp.js');
        $this->render_view('hrm/employee/temp');
    }
    private function render_view($path)
    {
        $this->data['top_navbar'] = $this->parser->parse('template/geerang/top_navbar_view', $this->left_sidebar_data, TRUE);
        $this->data['left_sidebar'] = $this->parser->parse('template/geerang/left_sidebar_view', $this->left_sidebar_data, TRUE);
        $this->data['breadcrumb_list'] = $this->parser->parse('template/geerang/breadcrumb_view', $this->breadcrumb_data, TRUE);
        $this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
        $this->data['another_css'] = $this->another_css;
        $this->data['another_js'] = $this->another_js;

        $this->parser->parse('template/geerang/homepage_view', $this->data);
    }
    public function tempsend()
    {
        $this->load->model('Sendmail_model', 'Sendmail_model');

        $post = (object) $this->input->post(null, false);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $filedata = $spreadsheet->getActiveSheet()
            ->toArray(null, true, true, true);
        unset($filedata[1]);
        $file = array_values($filedata);
        foreach ($file  as $key => $val) {

            if (strtolower($val['E']) == strtolower('Miss')) {
                $title = $val['E'] . ' ';
            } else {
                $title = $val['E'] . ' ';
            }
            $subject = "Username and password to use the GeeHRM";
            $massage  = "<br>Dear " . $title . $val['F'] . "  " .  $val['G'] . '';
            $massage .= "<br>Please use the username & password below to login to GeeHRM via mobile application or this link “Login” below. And please update your personal information by choosing “Profile”. ";
            $massage .= "<br><br><br>";
            $massage .= "Username :  " . $val['C'];
            $massage .= "<br>Password :  " . $val['D'];
            $massage .= "<br><br>";
            $massage .= "<br>QRCODE for Download Application";
            $massage .= "<br><br>";
            $massage .= "<table style='border:0'>
            <tr>
                <td>
                <img src='https://betatest.geerang.com//assets/images/appstroe.jpg' style='width:200px'>     
                </td>
                <td>
                    <img src='https://betatest.geerang.com/assets/images/ggplay.jpg' style='width:200px'>     
                </td>
            </tr>
                        </table>";
            $massage .= "<br><br>";


            $data = array(
                'email' => 'u.sarawut586@gmail.com',
                'message' => $massage . 'Press the link to <a href="https://gts.geerang.com/gmember">“Login”</a>  to login',
            );
            die;
            $this->Sendmail_model->sendtomail($subject, $data);
            die;
        }
        echo json_encode(['msg' => 'ok']);
    }
    public function importfiles()
    {
        $post = (object) $this->input->post(null, false);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $filedata = $spreadsheet->getActiveSheet()
            ->toArray(null, true, true, true);

        $rowdata = self::Rowunset($filedata);
        $tempdata = self::setColumn($rowdata);

        try {
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    private function Rowunset($data)
    {
        $rowunset = [1, 2, 3, 4, 5, 6];
        foreach ($rowunset as $key => $val) {
            unset($data[$val]);
        }

        return  array_values($data);
    }
    private function setColumn($data)
    {
        $columnUnset = ['BA'];

        $keyreplace = [
            'A' => 'A',
            'B' => 'row',
            'C' => 'title_name',
            'D' => 'title',
            'E' => 'firstname',
            'F' => 'lastname',
            'G' => 'nickname',
            'H' => 'idcard',
            'I' => 'employeecode',
            'J' => 'username',
            'K' => 'password',
            'L' => 'idpassport',
            'M' => 'idnonthai',
            'N' => 'title_en',
            'O' => 'firstname_en',
            'P' => 'lastname_en',
            'Q' => 'position',
            'R' => 'department',
            'S' => 'subdepartment',
            'T' => 'employee_type',
            'U' => 'employee_group',
            'V' => 'level_emp',
            'W' => 'level',
            'X' => 'salary',
            'Y' => 'branch_en',
            'Z' => 'branch',
            'AA' => 'email',
            'AB' => 'phone',
            'AC' => 'bank_id',
            'AD' => 'bank_name',
            'AE' => 'start_work',
            'AF' => 'date_now',
            'AG' => 'year',
            'AH' => 'month',
            'AI' => 'day',
            'AJ' => 'address',
            'AK' => 'province',
            'AL' => 'district',
            'AM' => 'amphoe',
            'AN' => 'zipcode',
            'AO' => 'pre_address',
            'AP' => 'pre_province',
            'AQ' => 'pre_district',
            'AR' => 'pre_amphoe',
            'AS' => 'pre_zipcode',
            'AT' => 'institute',
            'AU' => 'edu_level',
            'AV' => 'faculty',
            'AW' => 'major',
            'AX' => 'gpa',
            'AY' => 'start_edu',
            'AZ' => 'end_edu',
            'BA' => 'A',
        ];
        $item = [];
        foreach ($data as $key => $val) {

            $item = self::array_key_replace($key, $keyreplace[],  $val);
        }
    }
    private function array_key_replace($item, $replace_with, array $array)
    {
        $updated_array = [];
        foreach ($array as $key => $value) {
            if (!is_array($value) && $key == $item) {
                $updated_array = array_merge($updated_array, [$replace_with => $value]);
                continue;
            }
            $updated_array = array_merge($updated_array, [$key => $value]);
        }
        return $updated_array;
    }
}
